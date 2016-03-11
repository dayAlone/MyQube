<?
    use Bitrix\Highloadblock as HL;
    use Bitrix\Main\Entity;

    function getLikesList($element, $user = false, $photos = false) {

        global $USER;

        $cacheTime = 3600;
        $cacheId = 'likes_'.$element;
        $cachePath = '/likes';
        $obCache = new CPHPCache();


        if ($obCache->InitCache($cacheTime, $cacheId, $cachePath))
        {
            $vars = $obCache->GetVars();
            return $vars['data'];
        } else {

            global $CACHE_MANAGER;
	        $CACHE_MANAGER->StartTagCache($cachePath);
            $CACHE_MANAGER->RegisterTag($cacheId);

            $requiredModules = array('highloadblock');

            foreach ($requiredModules as $requiredModule)
            {
            	if (!CModule::IncludeModule($requiredModule))
            	{
            		ShowError(GetMessage("F_NO_MODULE"));
            		return 0;
            	}
            }

            if ($photos) {
                foreach ($photos as $key => &$value) {
                    $value = 'photo_'.$value;
                }
            }

            // hlblock info
            $hlblock_id = IB_LIKE;

            if (empty($hlblock_id))
            {
            	ShowError(GetMessage('HLBLOCK_LIST_NO_ID'));
            	return 0;
            }

            $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();

            if (empty($hlblock))
            {
            	ShowError('404');
            	return 0;
            }

            $entity = HL\HighloadBlockTable::compileEntity($hlblock);

            // uf info
            $fields = $GLOBALS['USER_FIELD_MANAGER']->GetUserFields('HLBLOCK_'.$hlblock['ID'], 0, LANGUAGE_ID);

            // pagination
            $limit = array(
            	'nPageSize' => $arParams['ROWS_PER_PAGE'],
            	'iNumPage' => is_set($_GET['PAGEN_1']) ? $_GET['PAGEN_1'] : 1,
            	'bShowAll' => true
            );

            // sort
            $sort_id = 'ID';
            $sort_type = 'DESC';

            // execute query

            $main_query = new Entity\Query($entity);
            $main_query->setSelect(array('*'));
            if ($user) {
                $main_query->setFilter(array('UF_ELEMENT_ID' => $element, 'UF_USER_ID' => $user));
            } else if($photos) {
                $main_query->setFilter(array('UF_ELEMENT_ID' => $photos));
            } else {
                $main_query->setFilter(array('UF_ELEMENT_ID' => $element));
            }

            $main_query->setOrder(array($sort_id => $sort_type));
            //$main_query->setSelect($select)
            //	->setFilter($filter)
            //	->setGroup($group)
            //	->setOrder($order)
            //	->setOptions($options);

            //$main_query->setLimit($limit['nPageSize']);
            //$main_query->setOffset(($limit['iNumPage']-1) * $limit['nPageSize']);

            $result = $main_query->exec();
            $result = new CDBResult($result);

            // build results
            $rows = array();

            $tableColumns = array();

            $liked = false;
            $userLike = false;

            while ($row = $result->Fetch())
            {
            	foreach ($row as $k => $v)
            	{

            		if ($k === 'UF_USER_ID' && $USER->IsAuthorized() && $v == $USER->GetID()) {

                        $liked = true;
                        $userLike = $row;
            		}

            		if ($k == 'ID')
            		{
            			$tableColumns['ID'] = true;
            			continue;
            		}

            		$arUserField = $fields[$k];

            		if ($arUserField["SHOW_IN_LIST"]!="Y")
            		{
            			continue;
            		}

            		$html = call_user_func_array(
            			array($arUserField["USER_TYPE"]["CLASS_NAME"], "getadminlistviewhtml"),
            			array(
            				$arUserField,
            				array(
            					"NAME" => "FIELDS[".$row['ID']."][".$arUserField["FIELD_NAME"]."]",
            					"VALUE" => htmlspecialcharsbx($v)
            				)
            			)
            		);

            		if($html == '')
            		{
            			$html = '&nbsp;';
            		}

            		$tableColumns[$k] = true;

            		$row[$k] = $html;
            	}


            	$rows[] = $row;
            }

            $data = array('rows' => $rows, 'fields' => $fields, 'colums' => $tableColumns, 'liked' => $liked, 'userLike' => $userLike);
            $CACHE_MANAGER->EndTagCache();

            if ($obCache->StartDataCache()) $obCache->EndDataCache(array("data" => $data));

            return $data;

        }
    }
?>

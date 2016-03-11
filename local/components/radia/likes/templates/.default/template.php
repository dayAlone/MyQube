<a
    href='#'
    data-id='<?=$arParams['ELEMENT']?>'
    class='like
    <?=$arResult['liked'] ? 'like--liked' : '' ?>
    <?=$arParams['GRAY'] ? 'like--gray' : '' ?>
    <?=$arParams['BLACK'] ? 'like--black' : '' ?>
    <?=$arParams['STRONG'] ? 'like--strong' : '' ?>
    <?=$arParams['INACTIVE'] ? 'like--innactive' : '' ?>
    '>
    <?=svg('like')?>
    <? if ($arParams['COUNTER'] !== 'N'):?>
        <span class='like__counter'><?=$arResult['total']?></span>
    <? endif;?>
</a>

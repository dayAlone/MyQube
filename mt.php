<?
if (mail("loputnev@gmail.com","test subject", "test body","From: test@myqube.ru"))
echo "Сообщение передано функции mail, проверьте почту в ящике.";
else
echo "Функция mail не работает, свяжитесь с администрацией хостинга.";
?>
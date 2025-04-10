<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/pages/message_page.css">
    <title>ЯМайки - Заказ оформлен</title>
</head>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <main>
        <section class="message__block-wrapper container">
            <div class="message__block green">
                <div class="message__block-title">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.00001 9.00001L8.25001 11.25L12.75 6.75001M9.00001 16.5C9.9851 16.5012 10.9607 16.3078 11.8708 15.9308C12.7809 15.5538 13.6076 15.0007 14.3033 14.3033C15.0007 13.6076 15.5538 12.7809 15.9308 11.8708C16.3078 10.9607 16.5012 9.9851 16.5 9.00001C16.5012 8.01492 16.3078 7.03929 15.9308 6.12919C15.5538 5.21909 15.0007 4.39245 14.3033 3.69676C13.6076 2.99932 12.7809 2.44621 11.8708 2.06922C10.9607 1.69224 9.9851 1.49879 9.00001 1.50001C8.01492 1.49879 7.03929 1.69224 6.12919 2.06922C5.21909 2.44621 4.39245 2.99932 3.69676 3.69676C2.99932 4.39245 2.44621 5.21909 2.06922 6.12919C1.69224 7.03929 1.49879 8.01492 1.50001 9.00001C1.49879 9.9851 1.69224 10.9607 2.06922 11.8708C2.44621 12.7809 2.99932 13.6076 3.69676 14.3033C4.39245 15.0007 5.21909 15.5538 6.12919 15.9308C7.03929 16.3078 8.01492 16.5012 9.00001 16.5Z"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h2>Ваш заказ успешно оформлен!</h2>
                </div>
                <p class="message__block-description">Спасибо за заказ! Мы свяжемся с вами в ближайшее время</p>
            </div>
            <a class="button" href="./">Вернуться на главную</a>
        </section>
    </main>
    <?php require_once 'includes/components/footer.php'; ?>
</body>

</html>
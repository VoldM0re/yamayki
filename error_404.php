<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="/yamayki/css/pages/message_page.css">
    <title>Ошибка 404</title>
</head>

<body>
    <?php require_once 'includes/components/header.php'; ?>
    <main>
        <section class="message__block-wrapper container">
            <div class="message__block">
                <div class="message__block-title">
                    <svg width="18" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.2 6.3L6.8 11.7M6.8 6.3L12.2 11.7M17 9C17 13.1421 13.6421 16.5 9.5 16.5C5.35786 16.5 2 13.1421 2 9C2 4.85786 5.35786 1.5 9.5 1.5C13.6421 1.5 17 4.85786 17 9Z"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h2>Страница не найдена :(</h2>
                </div>
                <p class="message__block-description">"Когда все дороги ведут в никуда - настала пора возвращаться домой" 🌆🔥</p>
            </div>
            <a class="button" href="./">Вернуться на главную</a>
        </section>
    </main>
    <?php require_once 'includes/components/footer.php'; ?>
</body>

</html>
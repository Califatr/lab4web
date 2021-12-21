<header>
    <div class="wrapper wrapper__head">
        <div class="container header__container">
            <div class="header-row">
                <a href="http://gallery.host/" class="logo">Gallery</a>
                <?php if($_SESSION['user'] == null) :?>
                <button id="open-forms-button" class="open-forms-button">Войти</button>
                <?php else:?>
                <a href="logout.php" id="logout-button" class="open-forms-button">Выйти</a>
                <?php endif;?>
            </div>
            <?php if($_SESSION['user'] != null):?>
            <div class="header-row header-row_welcome">
                <div class="header-row__welcome-text">Здравствуйте, <?= $_SESSION['user']['name']; ?></div>
            </div>
            <?php endif;?>
        </div>
    </div>
</header>
<link rel="stylesheet" href="/forum/v2/assets/style/side_bar.css">
<?php if ($info->mobile === true) {echo '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.side_bar.css">';} ?>
<div class="sidebar-toggle">
    <img src="/forum/assets/img/icon/menu.svg" alt="M">
</div>
<div class="sidebar-container">
    <div class="userview-container">
    <img class="sidebar-close" src="/forum/assets/img/icon/close.svg" alt="">
        <div class="userview-user">
            <div class="userview-image">
                <img src="/forum/assets/img/manexample.jpeg" alt="U">
            </div>
            <div class="userview-details">
                <div class="userview-name">
                    NathanZumbusch
                </div>
                <div class="userview-employment">
                    15, Schüler und Entwickler
                </div>
            </div>
        </div>
        <div class="userview-bar">
            <div class="userview-notification">
                <img src="/forum/assets/img/icon/notification.png" alt="N">
            </div>
            <div class="userview-settings">
                <img src="/forum/assets/img/icon/settings.png" alt="S">
            </div>
            <div class="userview-logout">
                <img src="/forum/assets/img/icon/logout.png" alt="L">
            </div>
        </div>
    </div>
    <div class="category-container">
        <?php foreach ($data->get_categories() as $category) {echo '
            <a class="category-header" link="' . $category . '">
            ' . $category . '
            <!--<img src="/forum/assets/img/icon/arrow.svg" alt="">-->
            <div class="bicu"></div>
            <div class="scdb"></div>
            </a>
        ';} // div with class bicu is background on chose, scdb is the side thing like on discord
        ?>
    </div>
    <div class="information-container">
        <div class="information-element">
            <img src="/forum/assets/img/icon/contact.svg" alt="Contact">
        </div>
        <div class="information-element">
            <img src="/forum/assets/img/icon/information.png" alt="Info">
        </div>
    </div>
</div>
<script src="/forum/v2/assets/script/side_bar.js" defer></script>
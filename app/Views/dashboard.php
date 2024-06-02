<div class="main_page_content d-flex">
    <div class="menu_box">
 
        <?php
 

            foreach (menus_array($user['id'],$user['u_type']) as $item) {
                
                    if (!isset($item['condition']) || $item['condition']) {
            ?>
                <a class="menu_icon href_loader text-dark cursor-pointer" href="<?= $item['url'] ?>">
                    <img src="<?= $item['icon'] ?>" class="menu_img">
                    <div class="menu-title"><?= $item['title'] ?></div>
                </a>
            <?php
                    }
            } ?>
         
    </div>
</div>
 
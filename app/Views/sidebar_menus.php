<?php 
    $uri = new \CodeIgniter\HTTP\URI(str_replace('/index.php','',current_url()));
?>
<div class="sidebar_menus <?= ($uri->getTotalSegments()<sn2())?'home':''; ?>">
    <div class="menu_container">
        <ul>
            <?php 
                foreach (menus_array($user['id'],$user['u_type']) as $side_item) {
                    if (!isset($side_item['condition']) || $side_item['condition']) {
                ?>
                    <li class="<?= (isset($side_item['class']))?$side_item['class']:''; ?>">
                        <a class=" href_loader d-flex cursor-pointer" href="<?= $side_item['url'] ?>">
                            <img src="<?= $side_item['icon'] ?>" class="menu_img my-auto">
                            <div class="ms-2 menu-title text-white my-auto"> <?= $side_item['title'] ?></div>
                        </a>
                    </li> 
                <?php
                    }
                } 
            ?>
        </ul>
    </div>
</div>
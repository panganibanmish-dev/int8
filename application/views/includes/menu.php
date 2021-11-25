<link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/d-din" type="text/css"/>
<?php $controller =  $this->router->fetch_class(); ?>
<?php $action =  $this->router->fetch_method(); 
$base_url =  base_url(); 

$items = [
    'dashboard'=>[
        'path'=>$base_url.'dashboard',
        'controller'=>'user',
        'action'=>'index',
        'check_permission'=>false,
        'name'=>'<i><img src="'.$base_url.'assets/img/icon04.svg" alt=""></i> Home'
    ],
    'developer-approval'=>[
        'path'=>$base_url.'user/developerApproval',
        'controller'=>'user',
        'action'=>'developerApproval',
        'check_permission'=>false,
        'name'=>'<i><img src="'.$base_url.'assets/img/icon06.svg" alt=""></i> Developer Approvals'
    ],
    'packages'=>[
        'path'=>$base_url.'package',
        'controller'=>'user',
        'action'=>'packages',
        'restrict_user_roles'=>[
            ROLE_ADMIN,
            ROLE_BUILDER
        ],
        'check_permission'=>true,
        'name'=>'<i><img src="'.$base_url.'assets/img/icon-packages.svg" alt=""></i> House + Land'
    ],
    'userlisting'=>[
        'path'=>$base_url.'userListing',
        'controller'=>'user',
        'action'=>'userListing',
        'restrict_user_roles'=>[
            ROLE_ADMIN,
        ],
        'check_permission'=>true,
        'name'=>'<i class="fa fa-users adjustmenu_font" aria-hidden="true"></i> User Management'
    ],
    'ticketmanagement'=>[
        'path'=>$base_url.'list-ticket',
        'controller'=>'TicketManagement',
        'action'=>'index',
        'restrict_user_roles'=>[
            ROLE_PURCHASER,
            ROLE_CONTRACTOR,
            ROLE_BUILDER
        ],
        'check_permission'=>true,
        'name'=>'<i class="fa fa-ticket" aria-hidden="true"></i> Help and Questions'
    ],
    'News'=>[
        'path'=>$base_url.'News',
        'controller'=>'News',
        'action'=>'index',
        'restrict_user_roles'=>[
            ROLE_PURCHASER,
            ROLE_CONTRACTOR,
            ROLE_BUILDER,
            ROLE_ADMIN
        ],
        'check_permission'=>true,
        'name'=>'<i class="fa fa-newspaper-o" aria-hidden="true"></i> News'
    ]
];

?>

<nav class="MainNav container-fluid">
    <div class="container">
        <a href="javascript:void(0);" class="BurgerMenu">Menu</a>
        <ul>
            <?php foreach( $items as $key => $item ){ 

                if( $item['check_permission'] and !in_array($this->session->userdata('role'), $item['restrict_user_roles'])  ){
                    continue;
                }

                $active = ($controller == $item['controller'] && $action == $item['action']) ? 'Active' : '';
                ?>

                <li><a class="<?= $active ?> header-font-style" href="<?= $item['path'] ?> ">
                <?= $item['name'] ?>
            </a></li>

            <?php } ?>
        </ul>
    </div>
</nav>

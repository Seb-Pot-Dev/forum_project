<?php
if(isset($result['data']['users'])){
    $users = $result['data']['users'];
}
if($_SESSION['user']->getRole()=='admin'){
    $admin=true;
}
else{
    $admin=false;
}?>
<table>
    <thead>
        <tr>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Date d'inscription</th>
            <th>Role</th>
            <th>Statut</th>
            <?php //Vérif si admin
            if($admin){ ?>
            <th>Admin</th>
            <?php }?>
        </tr>
    </thead>
    <tbody>
        <?php
foreach($users as $user){ ?>
        <tr>
            <td><?=$user->getNickname()?></td>
            <td><?=$user->getEmail()?></td>
            <td><?=$user->getRegistrationDate()?></td>
            <td><?=$user->getRole()?></td>
            <td><?php if($user->getBan()==0){echo "<p class='text-green'>valide</p>";}
            else{echo "<p class='text-red'>banni</p>";}?></td>
            <?php if($admin && $user->getBan()==0){ ?>
            <td><a class="text-red" href="index.php?ctrl=security&action=banUserFromList&id=<?=$user->getId() ?>">Ban</a></td>
            <?php }
            if($admin && $user->getBan()==1){?>
            <td><a class="text-green" href="index.php?ctrl=security&action=unbanUserFromList&id=<?=$user->getId() ?>">Deban</a></td>

            <?php } ?>
        </tr>
            <?php } ?>
    </tbody>
</table>

<p>Dear <?= $username ?></p>

<p>
   You have recently requested a password reset with Replique Ministry. <br/>
   Please click the following link to reset your password. <br/>
   <a href="http://repliqueministry.org/new/users/resetPassword/<?= $useremail ?>/<?= $token ?>">Reset my password</a>
</p>

<p>
   If the above link doesn't work, please try to copy the link below and paste it to your
   browser. <br/>
   http://repliqueministry.org/new/users/resetPassword/<?= $useremail ?>/<?= $token ?>
</p>

<p>
   The provided link will only be valid for 1 day. If you missed the time window, please
   request for another password reset.
</p>
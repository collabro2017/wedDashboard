<p>Hi <?= sprintf('%s %s & %s %s',
        $wedding->groom_first_name,
        $wedding->groom_last_name,
        $wedding->bride_first_name,
        $wedding->bride_last_name
    ) ?>,</p>

<p>Congratulations, you are getting married! We are very excited for you & are here to connect your guests & make your wedding day super fun!</p>

<p>Your admin login details are;</p>

<p>
    <b>Admin Email:</b> <?= $wedding->admin_email ?><br>
    <b>Admin Password:</b> <?= $wedding->admin_password ?>
</p>
<p>
    To start customizing your wedding app login to your admin control panel using the link below.
</p>

<a href="<?= \yii\helpers\Url::to(['couple/default/sign-in'], true) ?>"><?= \yii\helpers\Url::to(['couple/default/sign-in'], true) ?></a>
<p>
<b>Tip #1:</b> Setting up your own personalized wedding app is a big part of the fun & is a great activity to work on as an engaged couple ☺
</p>

<p>Below is the guest login section where your guests will be able to view & share pictures from your wedding.</p>


<a href="<?= \yii\helpers\Url::to(['/site'], true) ?>"><?= \yii\helpers\Url::to(['/site'], true) ?></a>

<p>You can see your custom app in action by downloading the WeDo app & logging in with your unique Wedding ID.</p>

<p>
<b>Tip #2:</b> Once your app is setup, you can preview / play ☺ with your creation before your big day by creating sample guest profiles. When you are happy with your wedding app you can “Clear User Data” through the admin control panel which resets WeDo leaving it ready for your guests to have fun on your wedding day!
</p>
<p>
<b>Tip #3:</b> Have Fun!
    </p>
Thank you for using Wedo!

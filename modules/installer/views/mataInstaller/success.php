<div class="installation-step" >
    <h1>Installation successful</h1>
    <p>Paste the below code in the <i>components</i> section of your config file. Thanks for using Mata!</p>    
    <br/>
    <pre>
     'matadb' => array(
        'connectionString' => 'mysql:host=<?php echo $model->DbHost ?>;dbname=<?php echo $model->DbName ?>',
        'emulatePrepare' => true,
        'username' => '<?php echo $model->DbUsername ?>',
        'password' => '<?php echo $model->DbPassword ?>',
        'charset' => 'utf8',
        'enableParamLogging' => true
    ),
    </pre>
</div>
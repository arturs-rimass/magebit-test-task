<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if(Input::exists()) {
        $validate = new Validate();
        $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));

        if($validate->passed()) {
            try {
                $user->update(array(
                    'name' => Input::get('name')
                ));

                Session::flash('home', 'Your details have been updated.');
                Redirect::to('index.php');

            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach($validate->errors() as $error) {
                echo $error, '<br>';
            }
        }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo escape($user->data()->name); ?>">

        <input type="submit" value="Update">
    </div>
</form>
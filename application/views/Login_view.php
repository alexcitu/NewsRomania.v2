<div class="container">

    <form class="form-signin" action="<?php echo base_url(); ?>login" method="post">
        <h2 class="form-signin-heading">Please login</h2>
        <label for="inputUser" class="sr-only">Username</label>
        <input name="username" type="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    </form>

</div>
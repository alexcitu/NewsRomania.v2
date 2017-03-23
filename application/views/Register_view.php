<div class="container">

    <form class="form-signin" action="<?php echo base_url(); ?>register" method="post">
        <h2 class="form-signin-heading">Register form</h2>


        <input name="nume" class="form-control" placeholder="Nume utilizator" required>

        <input name="prenume" class="form-control" placeholder="Prenume utilizator" required>

        <input name="username" class="form-control" placeholder="Username" required>

        <input name="password" type="password" class="form-control" placeholder="Password" required>

        <input  name="email" type="email" class="form-control" placeholder="Email address" required>

        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
    </form>

</div>
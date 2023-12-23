<div class="center-div">
    <div class="form-div">
        <div class="login-register">
            <a class="btn selected" id="loginbtn">Logowanie</a>
            <a class="btn" id="registerbtn">Rejestracja</a>
        </div>
        <form method="post">
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control" id="login" name="login" aria-describedby="loginHelp" placeholder="Wprowadź login">
            </div>
            <div class="form-group" id="email-div" style="display: none;">
                <label for="email">Adres email</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Wprowadź email">
            </div>
            <div class="form-group">
                <label for="password">Hasło</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Wprowadź hasło">
            </div>
            <div class="form-group" id="password2-div" style="display: none;">
                <label for="password2">Powtórz hasło</label>
                <input type="password" class="form-control" id="password2" name="password2" placeholder="Wprowadź hasło">
            </div>
            <div class="form-submit">
                <button type="submit" class="btn" id="submit" name="submit" value="login_in">Zaloguj się</button>
            </div>
        </form>
    </div>
</div>

<script src="app/login_register.js"></script>

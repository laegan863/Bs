document.querySelector('.bi-eye').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
});
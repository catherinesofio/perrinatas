function login($id, $username, $type) {
    sessionStorage.clear();
    sessionStorage.setItem('id', $id);
    sessionStorage.setItem('username', $username);
    sessionStorage.setItem('type', $type);

    setTimeout(() => {
        window.location.replace('/perrinatas/dashboard.php');
    }, 1);
}

function logout() {
    sessionStorage.clear();

    setTimeout(() => { 
        window.location.replace('/perrinatas/login.php');
    }, 1);
}
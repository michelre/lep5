const form = document.querySelector('#authentication-form');
const alert = document.querySelector('.alert-danger');
if(alert){
  alert.style.display = 'none';
}
form.addEventListener('submit', (event) => {
  event.preventDefault();
  alert.style.display = 'none';
  const login = document.querySelector('#usr').value;
  const password = document.querySelector('#pwd').value;
  const payload = { login, password };
  axios.post('/loginAction', payload).then((d) => {
    if(d.data.status === 'ko'){
      alert.style.display = 'block';
    } else {
      document.cookie = `p5_token=${d.data.token}`
      window.location.href = '/admin';
    }
  })
})

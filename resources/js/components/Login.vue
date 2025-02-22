<script>
export default {
    name: "Login",

    data() {
        return{
            email: null,
            password: null,
        }
    },
    methods:{
        login(){
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', {email: this.email, password: this.password})
                    .then( response => {
                        localStorage.setItem('authenticated', 'true');
                        this.$router.push({name: 'user.personal'})
                    })
                    .catch(err=>{
                        console.log(err.response)
                    })
            });
        }
    }
}
</script>

<template>
    <div class="login-form mt-3">

        <h2 class="mb-4">Вход в систему</h2>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input v-model="email" id="email" type="email" placeholder="Введите email" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="password">Пароль</label>
            <input v-model="password" id="password" type="password" placeholder="Введите пароль" class="form-control">
        </div>

        <button @click.prevent="login" class="btn btn-primary">Войти</button>

    </div>
</template>

<style scoped>
.login-form {
    max-width: 500px;
    margin: 0 auto;
}
</style>

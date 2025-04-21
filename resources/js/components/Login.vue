<script>
export default {
    name: "Login",

    data() {
        return{
            email: null,
            password: null,
            error: null
        }
    },
    methods:{
        login(){
            this.error = null;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', 
                    {email: this.email, password: this.password},
                    {
                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                )
                    .then( response => {
                        console.log('Login response:', response);
                        if (response.status === 200 || response.status === 204) {
                            console.log('Setting authenticated flag');
                            localStorage.setItem('authenticated', 'true');
                            console.log('Redirecting to personal page');
                            this.$router.replace({name: 'user.personal'})
                                .catch(err => {
                                    console.error('Navigation error:', err);
                                });
                        }
                    })
                    .catch(err=>{
                        console.error('Login error:', err);
                        this.error = err.response?.data?.message || 'Произошла ошибка при авторизации';
                    })
            });
        }
    }
}
</script>

<template>
    <div class="login-form mt-3">

        <h2 class="mb-4">Вход в систему</h2>

        <div v-if="error" class="alert alert-danger mb-3">
            {{ error }}
        </div>

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
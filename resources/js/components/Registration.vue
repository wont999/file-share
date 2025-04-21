<script>
export default {
    name: "Registration",

    data() {
        return {
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            error: null
        }
    },

    methods: {
        register() {
            this.error = null;
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/register', 
                        {
                            name: this.name,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation
                        },
                        {
                            headers: {
                                'Accept': 'application/json'
                            }
                        }
                    )
                        .then(response => {
                            if (response.status === 201 || response.status === 200) {
                                localStorage.setItem('authenticated', 'true');
                                this.$router.replace({name: 'user.personal'})
                                    .catch(err => {
                                        console.error('Navigation error:', err);
                                    });
                            }
                        })
                        .catch(err => {
                            console.error('Registration error:', err);
                            this.error = err.response?.data?.message || 'Произошла ошибка при регистрации';
                        })
                })
        }
    }
}
</script>

<template>
    <div class="register-form mt-3">

        <h2 class="mb-4">Регистрация</h2>

        <div v-if="error" class="alert alert-danger mb-3">
            {{ error }}
        </div>

        <div class="form-group mb-3">
            <label for="name">Имя</label>
            <input v-model="name" id="name" type="text" placeholder="Введите имя" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input v-model="email" id="email" type="email" placeholder="Введите email" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="password">Пароль</label>
            <input v-model="password" id="password" type="password" placeholder="Введите пароль" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input v-model="password_confirmation" id="password_confirmation" type="password"
                   placeholder="Повторно введите пароль" class="form-control">
        </div>

        <button @click.prevent="register" class="btn btn-primary">Регистрация</button>

    </div>
</template>

<style scoped>
.register-form {
    max-width: 500px;
    margin: 0 auto;
}
</style>

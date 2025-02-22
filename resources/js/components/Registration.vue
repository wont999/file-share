<script>
export default {
    name: "Registration",

    data() {
        return {
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
        }
    },

    methods: {
        register() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    })
                        .then(response => {
                            localStorage.setItem('authenticated', 'true');
                            this.$router.push({name: 'user.personal'})
                        })
                })
        }
    }
}
</script>

<template>
    <div class="register-form mt-3">

        <h2 class="mb-4">Регистрация</h2>

        <div class="form-group mb-3">
            <label for="name">Имя</label>
            <input v-model="name" id="name" type="name" placeholder="Введите имя" class="form-control">
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

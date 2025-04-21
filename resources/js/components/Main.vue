<template>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">FileSharing</h2>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h3>Система обмена файлами</h3>
                            <p class="lead">Безопасный и удобный способ обмена файлами</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Загрузка файлов</h5>
                                        <p class="card-text">Быстрая и безопасная загрузка файлов</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Скачивание</h5>
                                        <p class="card-text">Удобное скачивание файлов по уникальным ссылкам</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Безопасность</h5>
                                        <p class="card-text">Защищённая передача данных и контроль доступа</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Доступность</h5>
                                        <p class="card-text">Доступ к файлам с любого устройства 24/7</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Main'
}
</script>

<style scoped>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: scale(1.02);
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
}
</style> 
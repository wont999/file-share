<script>
export default {
    name: "Personal",
    data() {
        return {
            files: [],
            newPassword: '',
            currentFileId: null
        }
    },
    computed: {
        baseUrl() {
            return window.location.origin;
        }
    },
    mounted() {
        this.loadFiles();
    },
    methods: {
        loadFiles() {
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.get('/api/files')
                    .then(response => {
                        this.files = response.data.files;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        },
        
        deleteFile(fileId) {
            if (confirm('Вы уверены, что хотите удалить этот файл?')) {
                axios.get('/sanctum/csrf-cookie').then(() => {
                    axios.delete(`/api/files/${fileId}`)
                        .then(() => {
                            this.loadFiles();
                        })
                        .catch(() => {
                            alert('Ошибка при удалении файла');
                        });
                });
            }
        },
        
        showLinkForm(fileId) {
            this.currentFileId = fileId;
            this.newPassword = '';
        },
        
        hideLinkForm() {
            this.currentFileId = null;
        },
        
        createLink(fileId) {
            if (!this.newPassword || this.newPassword.length < 6) {
                alert('Пароль должен содержать не менее 6 символов');
                return;
            }
            
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post(`/api/files/${fileId}/links`, {
                    password: this.newPassword
                })
                    .then(() => {
                        this.hideLinkForm();
                        this.loadFiles();
                    })
                    .catch(() => {
                        alert('Ошибка при создании ссылки');
                    });
            });
        },
        
        deleteLink(linkId) {
            if (confirm('Вы уверены, что хотите удалить эту ссылку?')) {
                axios.get('/sanctum/csrf-cookie').then(() => {
                    axios.delete(`/api/links/${linkId}`)
                        .then(() => {
                            this.loadFiles();
                        })
                        .catch(() => {
                            alert('Ошибка при удалении ссылки');
                        });
                });
            }
        },
        
        uploadFile() {
            const formData = new FormData();
            const file = this.$refs.fileInput.files[0];
            formData.append('file', file);

            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post('/api/files', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(() => {
                    this.$refs.fileInput.value = ''; // очищаем input
                    this.loadFiles(); // обновляем список файлов
                })
                .catch(error => {
                    console.error(error);
                    alert('Ошибка при загрузке файла');
                });
            });
        }
    }
}
</script>

<template>
    <div class="container mt-4">
        <h2>Мои файлы</h2>
        
        <!-- Форма загрузки файла -->
        <div class="card mb-4">
            <div class="card-body">
                <form @submit.prevent="uploadFile" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file" class="form-label">Выберите файл для загрузки</label>
                        <input type="file" class="form-control" id="file" ref="fileInput" required>
                    </div>
                    <button type="submit" class="btn btn-success">Загрузить файл</button>
                </form>
            </div>
        </div>

        <div v-if="files.length === 0" class="alert alert-info">
            У вас пока нет загруженных файлов
        </div>
        
        <div v-else>
            <div class="card mb-3" v-for="file in files" :key="file.id">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{ file.original_name }}</h5>
                    <div>
                        <button class="btn btn-primary me-2" @click="showLinkForm(file.id)">
                            Создать ссылку
                        </button>
                        <button class="btn btn-danger" @click="deleteFile(file.id)">
                            Удалить
                        </button>
                    </div>
                </div>
                
                
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Размер:</strong> {{ Math.round(file.size / 1024) }} КБ
                    </div>
                    
                    <!-- форма создания ссылки -->
                    <div v-if="currentFileId === file.id" class="mb-3 p-3 border rounded">
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль для ссылки</label>
                            <div class="input-group">
                                <input type="password" class="form-control" v-model="newPassword" 
                                       placeholder="Минимум 6 символов">
                                <button class="btn btn-success" @click="createLink(file.id)">Создать</button>
                                <button class="btn btn-secondary" @click="hideLinkForm">Отмена</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- список ссылок -->
                    <div class="mt-3">
                        <h6>Ссылки:</h6>
                        <div v-if="!file.links || file.links.length === 0" class="text-muted">
                            Для этого файла еще не создано ссылок
                        </div>
                        <div v-else class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Статус</th>
                                        <th>
                                            Ссылка<br>
                                            <small class="text-muted">
                                                {{ baseUrl }}/file/download/[токен]
                                            </small>
                                        </th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="link in file.links" :key="link.id">
                                        <td>
                                            <span class="badge" :class="link.is_used ? 'bg-danger' : 'bg-success'">
                                                {{ link.is_used ? 'Использована' : 'Активна' }}
                                            </span>
                                        </td>
                                        <td>{{ link.token }}</td>
                                        <td>
                                            <a :href="'/file/download/' + link.token" class="btn btn-sm btn-info me-1" target="_blank">
                                                Скачать
                                            </a>
                                            <button class="btn btn-sm btn-danger" @click="deleteLink(link.id)">
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>

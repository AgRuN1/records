const { createApp } = Vue


createApp({
    methods: {
        obtain_data(index=1){
            fetch(`/api/records/all/${index}`)
                .then(response => response.json())
                .then(result => {
                    console.log('records all', result)
                    if (result.success) {
                        this.is_login = true
                        this.records = result.data.records
                        this.pages = result.data.pages
                        this.current_page = index
                    }
                });
        },
        pagination(index){
            if (index !== this.current_page) {
                this.obtain_data(index)
            }
        },
        validate_login(login){
            return Boolean(login.match('^[a-z]{4,40}$'))
        },
        validate_password(password){
            return Boolean(password.match('^[a-zA-Z0-9]{4,40}$'))
        },
        validate(login, password){
            if(!this.validate_login(login)){
                return 'Некорректный логин'
            }
            if(!this.validate_password(password)){
                return 'Некорректный пароль'
            }
            return ''
        },
        on_login(){
            this.login_error = this.validate(this.login, this.password)
            if(this.login_error === ''){
                fetch(`/api/users/login/${this.login}/${this.password}`)
                    .then(response => response.json())
                    .then(result => {
                        console.log('login', result)
                        if (result.success) {
                            this.user = {
                                login: '',
                                password: ''
                            }
                            this.obtain_data()
                        }
                    });
            }
        },
        on_signup(){
            this.signup_error = this.validate(this.login, this.password)
            if(this.signup_error === ''){
                fetch(`/api/users/add/${this.login}/${this.password}`)
                    .then(response => response.json())
                    .then(result => {
                        console.log('signup', result)
                        if (result.success) {
                            this.obtain_data()
                        } else {
                            this.signup_error = result.message
                        }
                    });
            }
        },
        on_logout(){
            fetch('/api/users/logout')
                .then(response => response.json())
                .then(result => {
                    console.log('logout', result)
                    if (result.success) {
                        this.is_login = false
                    }
                });
        },
        on_restore() {
            if (!this.validate_login(this.login)) {
                this.login_error = 'Некорректный логин'
                return
            }
            fetch(`/api/users/get/${this.login}`)
                .then(response => response.json())
                .then(result => {
                    console.log('get user', result)
                    if (result.success) {
                        this.user = result.data
                    }
                });
        }
    },
    data() {
        return {
            show: false,
            is_login: false,
            records: [],
            pages: 0,
            current_page: 0,
            login: '',
            password: '',
            login_error: '',
            signup_error: '',
            user: {
                login: '',
                password: ''
            }
        }
    },
    created() {
        this.obtain_data()
        this.show = true
    }
}).mount('#app')
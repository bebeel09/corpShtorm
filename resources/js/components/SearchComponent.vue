<style>
  .header-1__search_input:focus+.searchList {
        display: flex;
    }

    .mobilePh {
        color: red;
    }

    .workPh {
        color: blue;
    }

    .searchList {
        display: none;
        flex-direction: column;
        position: absolute;
        margin-top: 15px;

        background-color: #fff;
        border: 1px solid black;
        z-index: 1001;
    }

    .searchList:hover{
        display: flex;
    }
</style>


<template>
    <div class="header-1__search">
        <div class="header-1__search_input-block">
            <i class="fa fa-search header-1__search_input-icon"></i>
            <input v-model="search" type="text" class="header-1__search_input" id="search_input" placeholder="Сотрудник, новости или любой контент" spellcheck="false" autocomplete="off">
            <!-- <ul v-cloak v-if="posts" v-bind:style="{ width: width + 'px' }">
                <li v-for="(post,key) in searchData" :id="key+1" v-bind:class="[(key+1 == count) ? activeClass : '', menuItem]">

                    <a v-bind:href="post.url">{{ post.name }}</a>

                </li>
            </ul> -->
            <div class="searchList" v-bind:style="{ width: width + 'px' }">
                Пользователи
                    <a v-for="(user, key) in searchData.users" :id="key+1" v-bind:class="[(key+1 == count) ? activeClass : '', menuItem]" :href="user.path">
                        {{user.name}}
                    </a>

Посты
                    <a v-for="(post, key) in searchData.posts" :id="key+1" v-bind:class="[(key+1 == count) ? activeClass : '', menuItem]" :href="post.path">
                        {{post.title}}
                    </a>    
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import {debounce} from "../helpers";

    export default {
        // name: "SearchComponent",
        data() {
            return {
                search: '',
                searchData: '',
                count: 0,
                width: 0,
                activeClass: 'active',
                menuItem: 'menu-item'
            }
        },
        methods: {
            getPosts: debounce(function() {
                this.searchData = '';
                this.count = 0;
                self = this;
                if(this.search.trim() != ''){
                    axios.post(
                        '/search',
                        {
                            search : self.search
                        }
                    ).then(response => {
                        self.searchData = response.data;
                    }).catch(error => {
                        console.log('error');
                    })
                }
            },500),
            selectPost(keyCode) {
                if(keyCode == 40 && this.count < this.posts.length) {
                    this.count++;
                }
                if(keyCode ==38 && this.count > 1) {
                    this.count--;
                }
                if(keyCode == 13) {
                    document.getElementById(this.count).childNodes[0].click();
                }
            },
            clearData(event) {
                if(event.target.id != "search_input") {
                    this.posts = '', this.count = 0
                }
            }
        },
        mounted() {
            self = this;

            // Получаем ширину когда страница загружена
            this.width = document.getElementById("search_input").offsetWidth;

            // Получаем ширину когда страница ресайзится
            window.addEventListener('resize', function(event) {
                self.width = document.getElementById("search_input").offsetWidth;
            });

            // Очищаем поле при клике на боди
            document.body.addEventListener('click', function(e) {
                self.clearData(e);
            });

            document.getElementById('search_input').addEventListener('keydown', function(e){
                // проверяем какая кнопка была нажата
                // Валидные кнопки, нажатая кнопка
                let validKeys = [], keyCode;

                // Проверяем поддержку новой спецификации получения id кнопки
                if(e.key !== undefined) {
                    keyCode = e.key;
                } else if (e.keyIdentifier !== undefined) {
                    keyCode = e.keyIdentifier;
                } else if (e.keyCode !== undefined) {
                    keyCode = e.keyCode;
                }

                if(validKeys.includes(keyCode)) {
                    if(keyCode === 38 || keyCode === 40){
                        e.preventDefault();
                    }

                    if(keyCode === 40 && self.searchData == "") {
                        // Если посты пусты и строка поиска не пуста то вызовем поиск
                        self.getPosts();
                        return;
                    }

                    self.selectPost(keyCode);
                } else {
                    self.getPosts();
                }
            })


        }
    }
</script>

<style scoped>

</style>
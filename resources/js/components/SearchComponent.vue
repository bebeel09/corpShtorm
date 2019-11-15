<template>
    <div class="header-1__search">
        <div class="header-1__search_input-block">
            <i class="fa fa-search header-1__search_input-icon"></i>
            <input v-model="search" type="text" class="header-1__search_input" id="search_input" placeholder="Сотрудник, новости или любой контент" spellcheck="false" autocomplete="off">
            <div v-cloak v-bind:style="{ width: width + 'px', display: (search.trim() != '') ? 'block' : 'none' }" class="search-results" id="suggestion">

                <div class="suggestions-header">
                    <span>Пользователи</span>
                </div>

                <div v-if="posts && posts['users'].length > 0" class="suggestions-body">

                    <a v-for="(post,key) in posts['users']"
                       :id="key+1"
                       v-bind:class="[(key+1 == count) ? activeClass : '', menuItem]"
                       :href="post.path">
                        <div class="d-flex align-items-center">
                            <img :src='post.avatar' alt="user" style="width: 50px; height: 50px;">
                            <div>
                                <div>{{post.name}}</div>
                                <div style="font-size: 11px; font-style: italic">{{post.position}}</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around flex-wrap">
                            <div class="d-flex align-items-center" style="color: rgba(0,0,0, .5)">
                                <i class="fa fa-phone d-flex justify-content-center align-items-center" style="font-size: 24px"></i>
                                <span class="phone-number">{{post.work_phone}}</span>
                            </div>
                            <div class="d-flex align-items-center" style="margin: 0 20px; color: rgba(0,0,0, .5)">
                                <i class="fa fa-mobile d-flex justify-content-center align-items-center" style="font-size: 27px"></i>
                                <span class="phone-number">{{post.mobile_phone}}</span>
                            </div>
                            <div class="d-flex align-items-center" style="color: rgba(0,0,0, .5)">
                                <i class="fa fa-envelope d-flex justify-content-center align-items-center" style="font-size: 20px"></i>
                                <span class="phone-number">{{post.email}}</span>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="all-results suggest-string">
                        Все результаты
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                <div v-else class="suggest-string-disabled">
                    нет резутатов
                </div>

                <div class="suggestions-header">
                    <span>Посты</span>
                </div>

                <div v-if="posts && posts['posts'].length > 0" class="suggestions-body">
                    <a v-for="(post,key) in posts['posts']"
                       :id="key+1"
                       v-bind:class="[(key+1 == count) ? activeClass : '', menuItem]"
                       :href="post.path">
                        <span>{{post.title}}</span>
                        <div class="text-uppercase" style="background-color:#ff0015; color:white; padding: 1px 10px; font-size: 12px">#новости</div>
                    </a>
                    <a href="#" class="all-results suggest-string">
                        Все результаты
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                <div v-else class="suggest-string-disabled">
                    нет резутатов
                </div>


            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import $ from 'jquery';
    import {debounce, index} from "../helpers";

    export default {
        // name: "SearchComponent",
        data() {
            return {
                search: '',
                posts: '',
                count: 0,
                width: 0,
                activeClass: 'active',
                menuItem: 'suggest-string'
            }
        },
        methods: {
            getPosts: debounce(function() {
                this.posts = '';
                this.count = 0;
                self = this;
                if(this.search.trim() != ''){
                    axios.post(
                        '/search',
                        {
                            search : self.search
                        }
                    ).then(response => {
                        self.posts = response.data;
                    }).catch(error => {
                        console.log('error');
                    })
                }
            },500),
            selectPost(keyCode) {
                if(keyCode == 40 || keyCode == 'ArrowDown' && this.count < this.posts['posts'].length || this.count < this.posts['users'].length) {
                    this.count++;
                }
                if(keyCode == 38 || keyCode == 'ArrowUp' && this.count > 1) {
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
            },
            filterSearch(e) {
                self.getPosts();
            },
            navigateByArrows(el, increment) {
                let suggestions_item = $('#suggestion').find('.suggest-string'),
                    selected_suggestions_item = $('#suggestion').find('.suggest-string.active'),
                    item = suggestions_item.index(selected_suggestions_item),
                    current;
                el.preventDefault();
                current = item + increment;

                if(current <= -1) {
                    current = suggestions_item.length - 1;
                }
                if(current >= suggestions_item.length) {
                    current = 0;
                }
                selected_suggestions_item.toggleClass('active', false);
                selected_suggestions_item = $(suggestions_item[current]);
                selected_suggestions_item.toggleClass('active', true);
            },
            hideResult() {
                console.log('hide');
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
            // document.body.addEventListener('click', function(e) {
            //     self.clearData(e);
            // });

            document.getElementById('search_input').addEventListener('input', function(e){
                if(self) {
                    self.filterSearch(e);
                }
            });

            document.getElementById('search_input').addEventListener('keydown', function (e) {
                // проверяем какая кнопка была нажата
                // Валидные кнопки, нажатая кнопка
                let validKeys = [37, 38, 39, 40, 13, 'ArrowUp', 'ArrowDown'], keyCode;
                // Проверяем поддержку новой спецификации получения id кнопки
                if(e.key !== undefined) {
                    keyCode = e.key;
                } else if (e.keyIdentifier !== undefined) {
                    keyCode = e.keyIdentifier;
                } else if (e.keyCode !== undefined) {
                    keyCode = e.keyCode;
                }
                if(validKeys.includes(keyCode)) {
                    e.preventDefault();
                    if (keyCode === 13) {
                        self.filterSearch(e);
                    } else if (keyCode === 38 || keyCode === 'ArrowUp') {
                        self.navigateByArrows(e, -1);
                    } else if (keyCode === 40 || keyCode === 'ArrowDown') {
                        self.navigateByArrows(e, +1);
                    } else if (keyCode === 27) {
                        self.hideResult();
                    }
                }
            });


        }
    }
</script>

<style scoped>
    [v-cloak] {
        display: none;
    }
</style>
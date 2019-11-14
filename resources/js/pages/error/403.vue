<template>
    <div class="container d-flex justify-content-center flex-column">
        <div id="view" class="text-center p-5">
            <div class="bg-white p-2">
                <div id="code" class="font-weight-bold">403</div>
                <h1 class="text-danger">У вас нет разрешения на это</h1>
                <span>
                    Если вы считаете, что это сообщение не должно появляться, обратитесь к администратору.
                </span>
                <br>
                <div class="mt-3">
                    <button class="btn btn-outline-secondary" @click="back">Назад</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "403",
        methods: {
            back() {
                this.$router.push('/');
            }
        },
        computed: {
            //
        },
        mounted() {
            //
        },
        beforeDestroy() {
            //
        }
    }
</script>

<style scoped lang="scss">
    #view {
        font-family: 'Poppins', sans-serif;
        text-transform: uppercase;
        background: linear-gradient(45deg,
                #f6d200 10%,
                #181617 10%, #181617 20%,
                #f6d200 20%, #f6d200 30%,
                #181617 30%, #181617 40%,
                #f6d200 40%, #f6d200 50%,
                #181617 50%, #181617 60%,
                #f6d200 60%, #f6d200 70%,
                #181617 70%, #181617 80%,
                #f6d200 80%, #f6d200 90%,
                #181617 90%, #181617 100%
        );

        & > div > #code {
            font-size: 15vw;
            color: #f6d200;
        }
    }

    .container {
        height: calc(100vh - 100px);
    }
</style>
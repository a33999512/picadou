<template>
    <div class="gallery">
        <div class="displayed-img">
            <img :src="displayed">
        </div>
        <div class="img-viewport">
            <!-- <template>

            </template> -->
            <ul class="img-list">
                <template v-for="(item, key) in items">
                    <li :key="key" class="img-item" @click="itemClick(key)"><img :src="item.src"></li>
                </template>
                <!-- <li class="img-item"><img src="https://source.unsplash.com/random"></li>
                <li class="img-item"><img src="https://source.unsplash.com/random"></li>
                <li class="img-item"><img src="https://source.unsplash.com/random"></li>
                <li class="img-item"><img src="https://source.unsplash.com/random"></li>
                <li class="img-item"><img src="https://source.unsplash.com/random"></li>
                <li class="img-item"><img src="https://source.unsplash.com/random"></li>
                <li class="img-item"><img src="https://source.unsplash.com/random"></li> -->
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                // src
                // title
                // describe
                // price
                items: [
                    {
                        src: 'https://source.unsplash.com/random',
                        title: 'random',
                        describe: 'lorem mkasd',
                        price: 100,
                    },
                    {
                        src: 'https://source.unsplash.com/random',
                        title: 'random',
                        describe: 'lorem mkasd',
                        price: 100,
                    },
                    {
                        src: 'https://source.unsplash.com/random',
                        title: 'random',
                        describe: 'lorem mkasd',
                        price: 100,
                    },
                    {
                        src: 'https://source.unsplash.com/random',
                        title: 'random',
                        describe: 'lorem mkasd',
                        price: 100,
                    },
                ],
                displayed: 'https://scontent.ftpe3-1.fna.fbcdn.net/v/t1.0-9/23622471_1710785692288726_256628625464988385_n.jpg?_nc_cat=0&_nc_eui2=AeHXE_WCWxB28hi1RBrByFvE7FW46cEZo-0-lbXQTy2sPv8R9RaKSzGPgiKRixF6P3c5RfHaZN_cfRYK4eb53ucicW_9ccW5oN7AQF38BcIi-A&oh=3ab8292618ce4a51e10f30b0a46ef38f&oe=5BB9C765',
            };
        },
        methods: {
            itemClick(key) {
                this.displayed = this.items[key].src;
            },
        },
    }
</script>

<style scoped>
    .gallery {
        width: 100%;
    }
    .displayed-img {
        width: 100%;
    }
    .displayed-img img {
        width: 100%;
    }

    .img-viewport {
        background: rgba(200, 200, 200, 0.7);
        position: relative;
        overflow: auto;
        white-space: nowrap;
        width: 100%;
        margin: 0;
        padding: 0;
        max-height: 150px;
    }

    .img-list {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    .img-item {
        display: inline-block;
        border: rgba(255, 255, 255, 0) 1.5px solid;
    }

    .img-item:hover {
        cursor: pointer;
        border: #888 1.5px solid;
    }

    .img-item img {
        margin-left: 0.1rem;
        margin-right: 0.1rem;
        width: 56px;
    }
</style>
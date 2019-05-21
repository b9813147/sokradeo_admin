<template>
    <div>
        <b-row>
            <b-img left :src="src" v-bind="mainProps" rounded="circle" alt="Circle image" class="mr-1"></b-img>
            <b-col style="padding-top: 5px;">admin</b-col>
        </b-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                mainProps: {
                    // blank: true,
                    // blankColor: '#777',
                    width: 40,
                    height: 40,
                    class: 'm1',
                },
                src: 'https://truth.bahamut.com.tw/s01/201608/fdf10c50624e878ce71f98a155ddc19d.PNG'
            }
        }
    }
</script>

<template>
    <div class="timer-field">
        <input type="text" v-model="formatedTime"  class="timer-field__input" readonly/>
        <button class="timer-field__btn timer-field__btn--minus"  @click="subtract" @mousedown="subtractStart" @mouseup="stopCounter" @mouseleave="stopCounter">-</button>
        <button class="timer-field__btn timer-field__btn--plus" @click="add"  @mousedown="addStart" @mouseup="stopCounter" @mouseleave="stopCounter">+</button>
    </div>
</template>

<script>
    export default {
        props: {
            timeSeconds: Number,
            timeType: String
        },
        data(){
            return {
                time: this.timeSeconds,
                type: this.timeType,
                formatedTime: '00:02',
                interval: false,
            }
        },
        mounted() {
            // this.formatTime();
        },
        created() {
            this.formatTime();
        },
        methods: {
            subtract(){
                if(this.time >1)
                    this.time--;

               this.formatTime();
            },
            subtractStart(){
                if(!this.interval) {
                    this.interval = setInterval(function () {
                        if(this.time >1){
                            this.time--;
                            this.formatTime();
                        }else{
                            clearInterval(this.interval);
                            this.interval = false;
                        }

                    }.bind(this), 200);
                }
            },
            stopCounter(){
              clearInterval(this.interval);
              this.interval = false;
            },
            add(){
               this.time++;
               this.formatTime();
            },
            addStart(){
                if(!this.interval) {
                    this.interval = setInterval(function () {
                            this.time++;
                            this.formatTime();
                    }.bind(this), 200);
                }
            },
            formatTime(){
                this.formatedTime = new Date(this.time * 1000).toISOString().substr(11, 8);

                this.$emit('changeTime', {seconds: this.time, type: this.type});
            }
        }
    }
</script>

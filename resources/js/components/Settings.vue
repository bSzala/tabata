<template>
    <div class="control-wrapper">
        <div class="settings">
            <div class="setting">
                <span class="setting__title">Prepare</span>
                <timer-field v-bind:timeSeconds="prepareTime" timeType="prepare" @changeTime="updateTime"></timer-field>
            </div>
            <div class="setting">
                <span class="setting__title">Work</span>
                <timer-field  v-bind:timeSeconds="workTime" timeType="work" @changeTime="updateTime"></timer-field>
            </div>
            <div class="setting">
                <span class="setting__title">Rest</span>
                <timer-field v-bind:timeSeconds="restTime" timeType="rest" @changeTime="updateTime"></timer-field>

            </div>
            <div class="setting">
                <span class="setting__title">Cycles</span>
                <vue-slider ref="slider" v-model="value1"  v-bind="options1" class="setting__slider"></vue-slider>
            </div>
            <div class="setting">
                <span class="setting__title">Tabatas</span>
                <vue-slider  ref="slider" v-model="value2"  v-bind="options2"  class="setting__slider"></vue-slider>
            </div>
            <div class="setting">
                <span class="setting__title">
                   <strong>Total time:</strong> {{displayTimer}}
                </span>
            </div>
        </div>
        <div class="action-buttons">
            <button class="btn btn-control btn-control--green" v-if="pauseButtonStatus" @click="pauseWorkout"  v-text="!resumeStatus? 'Pause':'Resume'"></button>
            <button class="btn btn-control btn-control--green" @click="toggleWorkout" v-text="!working? 'Start': 'Stop'">Start</button>
        </div>
    </div>
</template>

<script>
import TimerField from "./TimerField";
import VueSlider from 'vue-slider-component';

export default {
    components: {
        'timer-field': TimerField,
        'vue-slider': VueSlider,
    },
    props:{
        cycles: Number,
        tabatas: Number,
        prepareTime: Number,
        workTime: Number,
        restTime: Number,
        displayTimer: String,
    },
    data: function(){
        return {
            value1: this.cycles,
            value2: this.tabatas,
            working: false,
            pauseButtonStatus: false,
            resumeStatus: false,
            options1: {
                dotSize: 34,
                duration: 0.7,
                min:1,
                max:30,
                tooltip: 'always',
                tooltipPlacement: 'right',
                tooltipFormatter: void 0,
                useKeyboard: false,
                keydownHook: null,
                dragOnClick: false,
                enableCross: true,
                fixed: false,
                tooltipStyle: void 0,
                stepStyle: void 0,
                stepActiveStyle: void 0,
                labelStyle: void 0,
                labelActiveStyle: void 0,
                clickable: true,
            },
            options2: {
                dotSize: 34,
                duration: 0.7,
                min:1,
                max:10,
                tooltip: 'always',
                tooltipPlacement: 'left',
                tooltipFormatter: void 0,
                useKeyboard: false,
                keydownHook: null,
                dragOnClick: false,
                enableCross: true,
                fixed: false,
                tooltipStyle: void 0,
                stepStyle: void 0,
                stepActiveStyle: void 0,
                labelStyle: void 0,
                labelActiveStyle: void 0,
                clickable: true,
            }
        }
    },
    watch:{
        value1: function(value){
            this.$emit('changedCycle', value);
        },
        value2: function(value){
            this.$emit('changeTabatas',value);
        }
    },
    mounted() {

    },
    methods:{
        updateTime(obj){
            this.$emit('changeTime', obj);
        },
        toggleWorkout(){
            this.working= !this.working;
            if(this.working){
                this.addPauseBtn();
            }else{
                this.removePauseBtn();
            }
            this.$emit('workout', this.working);

        },
        pauseWorkout(){
            this.$emit('pause');
            this.resumeStatus = !this.resumeStatus;
        },
        addPauseBtn(){
            this.pauseButtonStatus = true;
        },
        removePauseBtn(){
            this.pauseButtonStatus = false;
        }

    }

}
</script>

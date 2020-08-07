<template>
    <div class="container">
        <header-element></header-element>
        <main class="content-section">
            <nav class="nav">

            </nav>
            <div class="tabata">
                <div class="tabata__timer">
                    <h3 class="tabata__title" v-text="timerTitle"></h3>
                    <span>{{prettyTimer}}</span>
                </div>
                <div class="tabata__additional">
                    <div class="tabata__cycles">
                        <h3 class="tabata__heading">Cycles</h3>
                        <span class="tabata__number" v-text="cyclesValue"></span>
                    </div>
                    <div class="tabata__tabatas">
                        <h3 class="tabata__heading">Tabatas</h3>
                        <span class="tabata__number" v-text="tabatasValue"></span>
                    </div>
                </div>

            </div>
        </main>
        <div class="sidebar">
            <settings
                v-bind:cycles="cyclesValue"
                v-bind:tabatas="tabatasValue"
                v-bind:prepareTime="prepareTimeSecond"
                v-bind:workTime="workTimeSecond"
                v-bind:restTime="restTimeSecond"
                @changedCycle="updateCycle"
                @changeTabatas="updateTabatas"
                @changeTime="updateTime"
                @workout="workoutAction"
                @pause="pauseWorkout"
            ></settings>
        </div>
    </div>
</template>

<script>
    import Header from "./Header";
    import Settings from "./Settings";

    export default {
        components: {
            'header-element': Header,
            'settings': Settings
        },
        data(){
            return {
                cyclesValue: 8,
                tabatasValue: 1,
                prepareTimeSecond: 10,
                workTimeSecond: 20,
                restTimeSecond: 10,
                timer: 0,
                prettyTimer:0,
                workoutInterval:false,
                doneCycles: 0,
                doneTabatas: 0,
                timerTitle: ''

            }
        },
        mounted() {
            this.updateTimer();
        },
        methods: {
            updateCycle(cycle){
                this.cyclesValue = cycle;
                this.updateTimer();
            },
            updateTabatas(tabatas){
                this.tabatasValue = tabatas;
                this.updateTimer();
            },
            updateTimer(){
                const cycleWorkingTime = (this.cyclesValue * this.workTimeSecond);
                const cycleBreakTime = (this.cyclesValue*this.restTimeSecond);
                const singleTabataTime = this.prepareTimeSecond + cycleWorkingTime + cycleBreakTime;
                this.timer = singleTabataTime* this.tabatasValue;
                this.styleTimer();
            },
            styleTimer(){
                this.prettyTimer = new Date(this.timer * 1000).toISOString().substr(11, 8);
            },
            updateTime(obj){
                const seconds = obj.seconds;
                switch (obj.type){
                    case 'prepare':
                        this.prepareTimeSecond = seconds;
                        break;
                    case 'work':
                        this.workTimeSecond = seconds;
                        break;
                    case 'rest':
                        this.restTimeSecond = seconds;
                        break;
                    default:
                        throw Error('Not supported!');
                }

                this.updateTimer();
            },
            pauseWorkout(){
                if(this.workoutInterval){
                    clearInterval(this.workoutInterval);
                    this.workoutInterval= false;
                }else{
                    this.workoutAction(true);
                }
            },
            workoutAction(active){
                if(active){
                    //started
                    if(this.workoutInterval){
                       return;
                    }

                    this.workoutInterval = setInterval(()=> {
                        if(this.timer >1){
                            this.timer--;
                            this.styleTimer();
                        }else{
                            clearInterval(this.workoutInterval);
                            this.workoutInterval = false;
                        }
                    },1000);

                }else{
                    // stopped
                    clearInterval(this.workoutInterval);
                    this.workoutInterval = false;
                }
            },

        }
    }
</script>

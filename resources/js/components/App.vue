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
                        <span class="tabata__number" v-text="currentCycle"></span>
                    </div>
                    <div class="tabata__tabatas">
                        <h3 class="tabata__heading">Tabatas</h3>
                        <span class="tabata__number" v-text="currentTabata"></span>
                    </div>
                </div>

            </div>
        </main>
        <div class="sidebar">
            <settings
                ref="settings"
                v-bind:cycles="cycles"
                v-bind:tabatas="tabatas"
                v-bind:prepareTime="prepareTimeSecond"
                v-bind:workTime="workTimeSecond"
                v-bind:restTime="restTimeSecond"
                @changedCycle="updateCycle"
                @changeTabatas="updateTabatas"
                @changeTime="updateTime"
                @workout="startWorkout"
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
        props:{
            tabataCycle: Number,
            tabataCounter: Number,
            prepare: Number,
            work: Number,
            rest: Number,
        },
        data(){
            return {
                cycles: this.tabataCycle,
                tabatas: this.tabataCounter,
                prepareTimeSecond: this.prepare,
                workTimeSecond: this.work,
                restTimeSecond: this.rest,
                timer: 0,
                prettyTimer:0,
                workoutInterval:false,
                currentTabata: 0,
                doneStep: 0,
                tabataSteps: 0,
                timerTitle: '',
                currentCycle: 1,


            }
        },
        mounted() {
            this.updateTimer();
            this.countSteps();
            this.displayCycle(this.cycles);
            this.displayTabata(this.tabatas);
        },
        methods: {
            countSteps(){
                this.tabataSteps = 1 + (this.cycles*2);
            },
            updateCycle(cycle){
                this.cycles = cycle;
                this.displayCycle(this.cycles);
                this.updateTimer();
                this.countSteps();
            },
            updateTabatas(tabatas){
                this.tabatas = tabatas;
                this.updateTimer();
                this.displayTabata(tabatas);
                this.countSteps();
            },
            updateTimer(){
                const cycleWorkingTime = (this.cycles * this.workTimeSecond);
                const cycleBreakTime = (this.cycles*this.restTimeSecond);
                const singleTabataTime = this.prepareTimeSecond + cycleWorkingTime + cycleBreakTime;
                this.timer = singleTabataTime* this.tabatas;
                this.styleTimer();
            },
            styleTimer(){
                this.prettyTimer = new Date(this.timer * 1000).toISOString().substr(11, 8);
            },
            updateTimerTitle(title){
                this.timerTitle = title;
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
                    this.runInterval();
                }
            },

            runPrepare(){
                this.timer = this.prepareTimeSecond;
                this.styleTimer();
                this.displayCycle(0);
                this.updateTimerTitle('Prepare');
                this.runInterval();
            },
            finishTabata(){
                this.doneStep=0;
                if(this.currentTabata === this.tabatas){
                    this.prettyTimer = 'Done!';
                    this.updateTimerTitle('');
                    this.$refs.settings.toggleWorkout();
                }else{
                    this.workoutAction(true);
                }
                this.currentTabata++;

            },
            isWorkStep(){
                return Math.abs(this.doneStep % 2) == 1;

            },
            runWork(){
                this.timer = this.workTimeSecond;
                this.styleTimer();
                this.updateTimerTitle('Work');
                this.currentCycle++;
                this.runInterval();
            },
            runBreak(){
                this.timer = this.restTimeSecond;
                this.styleTimer();
                this.updateTimerTitle('Break');
                this.runInterval();
            },
            displayCycle(currentCycle){
                this.currentCycle = currentCycle;
            },
            displayTabata(tabata){
                this.currentTabata = tabata;
            },
            startWorkout(status){
                this.currentTabata=1;
                this.workoutAction(status);
            },
            workoutAction(active){
                if(active) {
                    //started
                    if (this.doneStep === 0) {
                        this.runPrepare();
                    } else if (this.doneStep === this.tabataSteps) {
                        this.finishTabata();
                    } else if (this.isWorkStep()) {
                        this.runWork();
                    } else {
                        this.runBreak();
                    }
                }else{
                    //stopped
                    this.clearInterval();
                }
            },
            runInterval(){
                if(this.workoutInterval){
                    return;
                }

                this.workoutInterval = setInterval(()=> {

                    if(this.timer >1){
                        this.timer--;
                        this.styleTimer();
                    }else{
                        this.clearInterval();
                        this.doneStep++;
                        this.workoutAction(true);
                    }
                },1000);
            },
            clearInterval(){
                clearInterval(this.workoutInterval);
                this.workoutInterval = false;
            },

        }
    }
</script>

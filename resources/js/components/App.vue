<template>
    <div class="container">
        <header-element></header-element>
        <main class="content-section">
            <nav class="nav">

            </nav>
            <div class="tabata">
                <div class="tabata__timer">
                    <span>04:00</span>
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
            <settings v-bind:cycles="cyclesValue" v-bind:tabatas="tabatasValue" @changedCycle="updateCycle" @changeTabatas="updateTabatas"></settings>
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
            }
        },
        mounted() {

        },
        methods: {
            updateCycle(cycle){
                this.cyclesValue = cycle;
            },
            updateTabatas(tabatas){
                this.tabatasValue = tabatas;
            }
        }
    }
</script>

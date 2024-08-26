<template>
    <PageHeader title="Activity Logs" pageTitle="List" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">

            <b-row class="g-2 mb-2 mt-n2">
                <b-col lg>
                    <div class="input-group mb-1">
                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                        <input type="text" v-model="filter.keyword" placeholder="Search Logs" class="form-control" style="width: 60%;">
                        <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                            <i class="bx bx-refresh search-icon"></i>
                        </span>
                    </div>
                </b-col>
            </b-row>
            <div class="profile-timeline">
                    <simplebar style="height: calc(100vh - 350px); overflow: auto;">
                        <div class="accordion accordion-flush" id="todayExample">
                            <div class="accordion-item border-0" v-for="(list,index) in lists" v-bind:key="index">
                                <div class="accordion-header" id="headingOne">
                                    <BLink class="accordion-button p-2 shadow-none" @click="toggleAccordion(index)" >
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-light text-muted rounded-circle">
                                                <i v-if="list.event === 'updated'" class="ri-edit-circle-fill text-warning"></i>
                                                <i v-else-if="list.event === 'created'" class="ri-add-circle-fill text-success"></i>
                                                <i v-else class="ri-user-3-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-1">{{list.log_name}}</h6>
                                                <small class="text-muted" v-if="list.event === 'updated'"> You {{list.description}} on {{list.created_at}}</small>
                                                <small class="text-muted" v-if="list.event === 'created'"> You created a new user on {{list.created_at}}</small>
                                            </div>
                                        </div>
                                    </BLink>
                                </div>

                                <BCollapse id="collapseOne" v-model="list.status">
                                    <div class="accordion-body ms-2 ps-5">
                                        <div v-if="list.event === 'updated'">
                                            Updated <span class="text-warning fst-italic" v-for="(old,key,index) in list.properties.old" v-bind:key="index">{{key}} : {{old}}, </span> to <span class="text-success fst-italic" v-for="(news,key,index) in list.properties.attributes" v-bind:key="index">{{key}} : {{news}}, </span>
                                        </div>
                                        <div v-if="list.event === 'created'">
                                            Created a new user, <span class="text-success fst-italic">{{list.name}}</span>
                                        </div>
                                    </div>
                                </BCollapse>
                            </div>
                        </div>
                    </simplebar>
                </div>
        </div>
    </div>
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
            },
            index: null
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal);
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/executive';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    count: ((window.innerHeight-350)/58),
                    option: 'activities'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;          
                }
            })
            .catch(err => console.log(err));
        },
        toggleAccordion(accordionNumber) {
            for (let key in this.lists) {
                if (key != accordionNumber) {
                this.lists[key].status = false;
                }
            }
            this.lists[accordionNumber].status = !this.lists[accordionNumber].status;
        }
    }
}
</script>
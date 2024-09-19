<template>
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Support Ticket" class="form-control" style="width: 60%;">
                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="openCreate()">
                    <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th class="text-center">#</th>
                    <th  style="width: 10%;">System</th>
                    <th  style="width: 10%;">Request #</th>
                    <th  style="width: 30%;">Problem Details</th>
                    <th  style="width: 20%;">Corrective Action</th>
                    <th  style="width: 10%;">Requested By</th>
                    <th  style="width: 5%;">Requested Date</th>
                    <th  style="width: 5%;" >Actions</th>
                </tr>
            </thead>

        
            <tbody>
         
                <tr v-for="(list, index) in lists" 
    v-bind:key="index" 
    :class="{
        'bg-danger-subtle': list.onhand == 0, // bg-danger-subtle if onhand is 0
        'bg-secondary': list.is_closed,  // red background if is_closed is true
        'bg-white': !list.is_closed,  // white background if is_closed is false
        'text-white': list.is_closed,  // white background if is_closed is false
                  
    }">
    <td class="text-center"> 
        {{ index + 1 }}
    </td>
    <td>
        <span v-if="list.system">{{ list.system.name }}</span>
    </td>
    <td class="text-center">
        <span v-if="list.request_number">{{ list.request_number }}</span>
    </td>
    <td>
        <span v-if="list.problem_details">{{ list.problem_details }}</span>
    </td>
    <td> 
        <span v-if="list.corrective_action">{{ list.corrective_action }}</span>
    </td>
    <!-- show if user is administrator -->
    <td>
        <span v-if="list.requested_by">{{ list.requested_by.username }}</span>
    </td>
    <td>
        <span v-if="list.requested_date">{{ list.requested_date }} </span>
    </td>
    <td class="text-end">
        <b-button @click="openEdit(list,index)" variant="soft-warning" class="me-1" v-b-tooltip.hover title="Edit" size="sm">
            <i class="ri-pencil-fill align-bottom"></i>
        </b-button>
        <b-button @click="openAction(list,index)" variant="soft-success" class="me-1" v-b-tooltip.hover title="Corrective Action" size="sm">
            <i class="ri-hammer-fill align-bottom"></i>
        </b-button>
    </td>
</tr>

            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <Create @add="fetch()" :dropdowns="dropdowns" @update="updateData" ref="create"/>
</template>
<script>
import _ from 'lodash';
import Create from '../Modals/Create.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['dropdowns'],
    components: { Create, Pagination },
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
            page_url = page_url || '/support-tickets';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    option: 'support_tickets'
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

            console.log('hey',110);
        },
        openCreate(){
            this.$refs.create.show();
        },
        openEdit(data,index){
            this.index = index;
            this.$refs.create.edit(data ,'edit');
        },
        openAction(data,index){
            this.index = index;
            this.$refs.create.edit(data , 'action');
        },
        updateData(data){
            this.lists[this.index] = data;
        }
    }
}
</script>
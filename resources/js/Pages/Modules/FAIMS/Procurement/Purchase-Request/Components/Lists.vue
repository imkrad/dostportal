<template>
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Purchase Request" class="form-control" style="width: 60%;">
                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="goCreatePage()">
                    <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div>
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th>#</th>
                    <th>Request #</th>
                    <th>Request Purpose</th>
                    <th>Division</th>
                    <th>Requested By</th>
                    <th>PO #</th>
                    <th>PAP Code</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        
            <tbody>
                <tr class="custom-hover-row" v-for="(list, index) in lists" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ list.purchase_request_number }}</td>
                    <td>{{ list.purchase_request_purpose }}</td>
                    <td>{{ list.section.division.name }}</td>
                    <td>{{  list.requested_by }}</td>
                    <td></td>
                    <td></td>
                    <td>
                        <b-badge 
                            :variant="getBadgeVariant(list.status.name)" 
                            style="color: white;">
                            {{ list.status.name }}
                        </b-badge>  
                    </td>
                    <td>
                        <b-dropdown size="sm" variant="success">
                            <template #button-content>
                            <i class="ri-more-2-fill align-bottom"></i>
                            </template>

                            <b-dropdown-item @click="editItem">
                            <i class="ri-edit-2-fill align-bottom me-1"></i> <!-- Icon for Edit -->
                            Edit
                            </b-dropdown-item>
                            <b-dropdown-item @click="viewItem">
                            <i class="ri-eye-fill align-bottom me-1"></i> <!-- Icon for View -->
                            View
                            </b-dropdown-item>
                            <b-dropdown-item @click="reviewItem">
                            <i class="ri-check-double-fill align-bottom me-1"></i> <!-- Icon for Review -->
                            Review
                            </b-dropdown-item>
                            <b-dropdown-item @click="approveItem">
                            <i class="ri-check-fill align-bottom me-1"></i> <!-- Icon for Approve -->
                            Approve
                            </b-dropdown-item>
                            <b-dropdown-item @click="printPreview(list)">
                            <i class="ri-printer-fill align-bottom me-1"></i> <!-- Icon for Print -->
                            Print Preview
                            </b-dropdown-item>
                            <b-dropdown-item @click="cancelItem">
                            <i class="ri-close-fill align-bottom me-1"></i> <!-- Icon for Cancel -->
                            Cancel
                            </b-dropdown-item>
                        </b-dropdown>
                    </td>
                </tr>

            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div> <Create @add="fetch()" :dropdowns="dropdowns" @items="items" ref="create"/>
   
</template>
<script>
import _ from 'lodash';
import Create from '../Modals/Create.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
import { router } from '@inertiajs/vue3';
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
            page_url = page_url || '/faims/purchase-request';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    option: 'purchase_request'
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

        goCreatePage(){
            router.get('/faims/purchase-request', {option: 'create_purchase_request'});
        },
        openEdit(data,index){
            router.get('/faims/purchase-request/create/index',{} );
        },
        openAction(data,index){
            this.index = index;
            this.$refs.create.edit(data , 'action');
        },
        updateData(data){
            this.lists[this.index] = data;
        },

        getBadgeVariant(status_name) {
            switch (status_name) {
                case 'Created':
                    return 'warning'; // Maps to Bootstrap's warning variant
                case 'Reviewed':
                    return 'info';    // Maps to Bootstrap's info variant
                case 'Approved':
                    return 'success';  // Maps to Bootstrap's success variant
                default:
                    return 'secondary'; // Default variant if none match
            }
        },

        printPreview(data){
            router.get('/faims/purchase-request', { data: data , option: 'print_preview' });
        },
    }
}
</script>

<style scoped>
.custom-hover-row:hover {
    background-color: hsl(0, 29%, 97%); 
}

</style>
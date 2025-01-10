<template>
    <b-modal v-model="showModal" header-class="p-3" title="Continue?" size="lg" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop >
        <form class="customform">
            <h3>Do you want to add this to Request For Quotation Number?</h3>
        </form>
   
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>No, Just Print Preview</b-button>
            <b-button @click="goNext(data)" variant="success"  block>Yes</b-button>
        </template>
        
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';


export default {
    components: {  },
    props:['data'],
    data(){
        return {
            currentUrl: window.location.origin,        
            showModal: false,
        }
    },


    methods: { 

        show(){
            // this.form.reset();
            this.showModal = true;
        },
      
        hide(){
            // this.form.reset();
            this.showModal = false;
        },

        goNext(data){
             window.open('/faims/quotations/request/'+data.id + '?purchase_request_number='+data.purchase_request_number 
                                        + '&supplier_id='+data.supplier_id 
                                        + '&address='+data.address
                                        + '&supplier_officer_id='+data.supply_officer_id
                                        + '&date_submitted='+data.submission_date
                                        + '&purchase_request_date='+data.purchase_request_date);
        }



       
    }
}
</script>
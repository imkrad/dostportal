<template>
    <b-modal v-model="showModal" header-class="p-3" title="Proceed to BAC Resolution?" size="lg" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <div>
                <b-form-checkbox v-model="checkedBidsDescriptions"> 
                    <h5>
                        Done checking Bids Descriptions?
                    </h5>
                </b-form-checkbox>
                <b-form-checkbox v-model="checkedBidsPrice"> 
                    <h5>
                        Done checking Bids Price?
                    </h5>
                </b-form-checkbox>
            </div>           
        </form>

        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>No</b-button>
            <b-button @click="goNext()" variant="success" block :disabled="!bothChecked">Yes</b-button>
        </template>
    </b-modal>
</template>

<script>
export default {
    data(){
        return {
            showModal: false,
            checkedBidsDescriptions: false,
            checkedBidsPrice: false,
        }
    },

    computed: {
        bothChecked() {
            return this.checkedBidsDescriptions && this.checkedBidsPrice;
        }
    },

    methods: { 
        show(){
            this.showModal = true;
        },
        hide(){
            this.showModal = false;
        },
        goNext(data){
            window.open('/faims/quotations/request/'+data.id + '?purchase_request_number='+data.purchase_request_number 
                                        + '&supplier_id='+data.supplier_id 
                                        + '&address='+data.address
                                        + '&supplier_officer_id='+data.supply_officer_id
                                        + '&date_submitted='+data.submission_date
                                        + '&purchase_request_date='+data.purchase_request_date);
        },
    }
}
</script>

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
            <b-button @click="submit(data)" variant="success" block :disabled="!bothChecked">Yes</b-button>
        </template>
    </b-modal>
</template>

<script>
import { router } from '@inertiajs/vue3';
export default {
    props:['data'],
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

        submit(data){
            console.log(this.data, 5555);
            const bidsForAward = [];
            const bidsNotForAward = [];

            this.data.forEach(item => {
                item.bids_details.forEach(bid => {
                    if (bid.is_checked) {
                        bidsForAward.push({
                            id:bid.id,
                            purchase_request_id: item.purchase_request.id,
                            supplier_id: item.supplier.id,
                            supplier: item.supplier.name,
                            bid_description: bid.bids_description,
                            quantity: bid.bids_quantity,
                            unit: bid.unit_type.name_long,
                            abc: bid.bids_abc,
                            price: bid.bids_price,
                            total_price: bid.bids_price * bid.bids_quantity
                        });
                    }
                    else{
                        bidsNotForAward.push({
                            id:bid.id,
                            purchase_request_id: item.purchase_request.id,
                            supplier_id: item.supplier.id,
                            supplier: item.supplier.name,
                            bid_description: bid.bids_description,
                            quantity: bid.bids_quantity,
                            unit: bid.unit_type.name_long,
                            abc: bid.bids_abc,
                            price: bid.bids_price,
                            total_price: bid.bids_price * bid.bids_quantity
                        });
                    }
                });
            });

            router.post('/faims/bids', {  
                                        purchase_request_id: data.purchase_request_id, 
                                        items: bidsForAward, 
                                        itemsNotAvailableForAward: bidsNotForAward, 
                                        option: 'save_bids_for_award' 
                                    });
            this.hide();
        }

    }
}
</script>

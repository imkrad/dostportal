<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" :title="(!editable) ? 'Create Support Ticket' : 'Edit Support Ticket'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12" class="mt-2">
                    <InputLabel for="system" value="System Title*" :message="form.errors.system"/>
                    <Multiselect 
                    :options="dropdowns.systems" 
                    v-model="form.system_id"
                    @input="handleInput('special_id')"
                    :searchable="true" label="name"
                    placeholder="Select System"
                    :disabled="isReadOnly"/>
                </BCol>

                <!-- if system is FAIMS this will be displayed-->
                <template v-if="form.system_id == 1">
                    <BCol lg="12" class="mt-2">
                        <InputLabel value="Request No.*" :message="form.errors.request_number"/>
                        <TextInput v-model="form.request_number" type="text" class="form-control" placeholder="Please enter request number" @input="handleInput('short')" :light="true" :disabled="isReadOnly"/>
                    </BCol>

                    <BCol lg="12" class="mt-2">
                        <InputLabel value="Disbursement Voucher No." :message="form.errors.dv_number"/>
                        <TextInput v-model="form.dv_number" type="text" class="form-control" placeholder="Please enter DV number if applicable" @input="handleInput('short')" :light="true" :disabled="isReadOnly"/>
                    </BCol>

                    <BCol lg="12" class="mt-2">
                        <InputLabel value="Payee*" :message="form.errors.payee"/>
                        <TextInput v-model="form.payee" type="text" class="form-control" placeholder="Please enter payee fullname" @input="handleInput('short')" :light="true" :disabled="isReadOnly"/>
                    </BCol>

                    <BCol lg="12" class="mt-2">
                        <InputLabel value="Amount*" :message="form.errors.amount"/>
                        <TextInput v-model="form.amount" type="number" class="form-control" placeholder="Please enter amount" @input="handleInput('short')" :light="true" :disabled="isReadOnly"/>
                    </BCol>

                    <BCol lg="12" class="mt-2">
                        <InputLabel value="Status*" :message="form.errors.status"/>
                        <Multiselect 
                        :options="['Created', 'Submitted', 'Verified' , 'Validated' ,'Obligated' , 'Charged' , 'Approved' ,'Funds Available']" 
                        v-model="form.status"
                        :searchable="true" 
                        placeholder="Select Status"
                        :disabled="isReadOnly"/>
                    </BCol>

                </template>

                <BCol lg="12" class="mt-2">
                    <InputLabel for="problem_details" value="Problem Details *" :message="form.errors.problem_details"/>
                    <b-form-textarea
                        id="textarea"
                        v-model="form.problem_details"
                        placeholder="Enter your concerns or problems you want to be solved base on the system selected"
                        rows="3"
                        max-rows="6"
                        :disabled="isReadOnly"></b-form-textarea>
                </BCol>

                <BCol lg="12" class="mt-2" v-if="editable">
                    <InputLabel for="corrective_action" value="Corrective Action " :message="form.errors.corective_action"/>
                    <b-form-textarea
                        id="textarea"
                        v-model="form.corrective_action"
                        placeholder="Enter action taken for this support ticket"
                        rows="3"
                        max-rows="6"
                        ></b-form-textarea>
                </BCol>
                <BCol lg="12" class="mt-2" v-if="editable">
                    <b-form-checkbox radio size="lg" v-model="form.is_closed">is Closed?</b-form-checkbox>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-4 mb-0"/></BCol>
            </BRow>
        </form>
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputError, InputLabel, TextInput, Multiselect },
    props:['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                system_id: null,
                request_number: null,
                dv_number: null,
                payee: null,
                amount: null,
                status: null,
                problem_details: null,
                corrective_action: null,
                action_clicked: null,
                is_closed: false,
                option: 'support-ticket'
            }),
            showModal: false,
            editable: false
        }
    },


    watch: {
        'form.action_clicked': function(newVal) {
            this.isReadOnly = newVal === 'action';  // Update isReadOnly based on the new value
        }
    },

    methods: { 
        show(){
            this.editable = false;
            this.form.reset();
            this.showModal = true;
        },
        submit(){
            if(this.editable){
                this.form.put('/support-tickets/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('update',this.$page.props.flash.data.data);
                        this.form.reset();
                        this.hide();
                    }
                });
            }else{
                this.form.post('/support-tickets/create',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('add',true);
                        this.hide();
                    },
                });
            }
        },
        edit(data, action){
            this.editable = true;
            this.form.id = data.id;
            this.form.system_id = data.system.id;
            this.form.request_number = data.request_number;
            this.form.dv_number = data.dv_number;
            this.form.payee = data.payee;
            this.form.amount = data.amount;
            this.form.status = data.status;
            this.form.problem_details = data.problem_details;
            this.form.corrective_action = data.corrective_action;
            if(data.is_closed == 1){
                this.form.is_closed = true;
            }
            else{
                this.form.is_closed = false
            }
            this.form.action_clicked = action;
            this.showModal = true;
        },

        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>
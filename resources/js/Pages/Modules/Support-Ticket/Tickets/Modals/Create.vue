<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" :title="(!editable) ? 'Create Support Ticket' : 'Edit Rate'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12" class="mt-2">
                    <InputLabel for="system" value="System Title *" :message="form.errors.system"/>
                    <Multiselect 
                    :options="dropdowns.systems" 
                    v-model="form.special_id"
                    @input="handleInput('special_id')"
                    :searchable="true" label="name"
                    placeholder="Select System"/>
                </BCol>
                <BCol lg="12" class="mt-2">
                    <InputLabel for="region" value="Problem Details *" :message="form.errors.laboratory_type"/>
                    <b-form-textarea
                        id="textarea"
                        v-model="text"
                        placeholder="Enter your concerns or problems you want to be solved base on the system selected"
                        rows="3"
                        max-rows="6"
                        ></b-form-textarea>
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
                special_id: null,
                administrative_id: null,
                salary_id: null,
                option: 'rate'
            }),
            showModal: false,
            editable: false
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
                this.form.put('/hr/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('update',this.$page.props.flash.data.data);
                        this.form.reset();
                        this.hide();
                    }
                });
            }else{
                this.form.post('/hr',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('add',true);
                        this.hide();
                    },
                });
            }
        },
        edit(data){
            this.editable = true;
            this.form.id = data.id;
            this.form.special_id = data.special_id;
            this.form.administrative_id = data.administrative_id;
            this.form.salary_id = data.salary_id;
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
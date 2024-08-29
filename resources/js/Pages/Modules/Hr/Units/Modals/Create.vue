<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" :title="(!editable) ? 'Create Rate' : 'Edit Rate'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12" class="mt-2">
                    <InputLabel value="Name" :message="form.errors.name"/>
                    <TextInput v-model="form.name" type="text" class="form-control" placeholder="Please enter name" @input="handleInput('name')" :light="true" />
                </BCol>
                <BCol lg="12" class="mt-2">
                    <InputLabel value="Short" :message="form.errors.short"/>
                    <TextInput v-model="form.short" type="text" class="form-control" placeholder="Please enter short" @input="handleInput('short')" :light="true" />
                </BCol>
                <BCol lg="12" class="mt-2">
                    <InputLabel for="region" value="Unit" :message="form.errors.unit_id"/>
                    <Multiselect 
                    :options="dropdowns.units" 
                    v-model="form.unit_id"
                    @input="handleInput('unit_id')"
                    :searchable="true" label="name"
                    placeholder="Select Unit"/>
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
                name: null,
                short: null,
                unit_id: null,
                option: 'unit'
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
            this.form.name = data.name;
            this.form.short = data.short;
            this.form.unit_id = data.unit_id;
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
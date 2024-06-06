<template>
    <div class="q-pa-md"     style="display: flex; justify-content: flex-end;"
>
  
  <q-form
    @submit="onSubmit"
    @reset="onReset"
    class="q-gutter-md q-dense q-pa-md"
    style="min-width: 70%"
      >
    <q-input
    dense
          v-model="fname"
      label="first_name *"
      lazy-rules
      :rules="[ val => val && val.length > 0 || '']"
      class="q-mb-md"
    />
    <q-input
    dense
          v-model="lname"
      label="last_name"
      
    />
    <q-input
    dense
          v-model="email"
      label="email"
      
    />
    <q-input
    dense
          v-model="phoneno"
      label="phone_number *"
      lazy-rules
      :rules="[ val => val && val.length > 0 || '']"
    />
    <q-input
    dense
      v-model="address"
      label="address "
      
    />
   
      
   
        <q-select
    v-model="group"
    multiple
    dense
    options-dense
    emit-value
    :options=groupOptions
    option-value="group_name"
    option-label="group_name"
    options-cover
    style="min-width: 150px"
    label="Groups"
  />
    <div>
      <q-btn label="Submit" type="submit" color="primary"/>
      <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
    </div>
  </q-form>

</div>
 <div v-if="isLoading">Loading... 
 </div>
  <div v-else class="q-pa-md">
   
    <q-table
      style="height: 400px"
      flat bordered
      title="Contacts"
      :rows=allContacts
      :columns="columns.filter(col => col.name !== 'id')"      
      row-key="first_name"
      virtual-scroll
            >
            
     '
      <template v-slot:body="props">
        <q-tr :props="props">
         
          <q-td
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
          >
            {{ col.value }}
          </q-td>
          <q-td auto-width>
            <q-btn
              size="sm"
              color="primary"
              round
              dense
              icon="edit"
              @click="onUpdate(props.row)"
            />
            <q-btn
              size="sm"
              color="negative"
              round
              dense
              icon="delete"
              @click="onDelete(props.row)"
            />
          </q-td>
        </q-tr>
        
      </template>
    </q-table>
  </div>
  
</template>

<script setup>
import { ref, computed  } from 'vue'
import { useQuasar } from 'quasar'
import { useContactStore } from "src/stores/contact_store";
import { useQuery, useMutation } from "vue-query";

const contactStore = useContactStore();
const { data: allContacts, isLoading: isLoading, error: error, refetch: refetch } = useQuery("contactsyfkjb", contactStore.fetchContacts);

const { data: allGroups, isLoading: isLoadingG, error: errorG, refetch: refetchG } = useQuery("contacts", contactStore.fetchGroups);

const groupOptions = computed(() => {
  const groupsSet = new Set();
  allGroups.value?.forEach(group => {
      groupsSet.add(group.group_name);
    });
  return Array.from(groupsSet).map(group_name => ({ group_name }));
});

console.log(groupOptions);

const $q = useQuasar();
const fname = ref('');
const lname = ref('');
const email = ref('');
const phoneno = ref('');
const address = ref('');
const group= ref('');
const columns = [
{ name: 'id', hidden:true, label: 'ID', field: 'id', sortable: true,  align: 'left' },
  { name: 'first_name', required: true, label: 'First Name', field: 'first_name', sortable: true, align: 'left' },
  { name: 'last_name', label: 'Last Name', field: 'last_name', sortable: true, align: 'left' },
  { name: 'email', label: 'Email', field: 'email', sortable: true, align: 'left' },
  { name: 'phone_number', required: true, label: 'Phone Number', field: 'phone_number', sortable: true, align: 'left' },
  { name: 'address', label: 'Address', field: 'address', sortable: true, align: 'left' },
   {
    name: 'groups',
    label: 'Groups',
    field: row => {
      if (row.groups && row.groups.length > 0) {
        return row.groups.map(group => group.group_name).join(', ');
      } else {
        return ''; // Or any default value you want to display when data is not available
      }
    },
    sortable: false,
    align: 'left'
  }
];

const { mutate: createContact, isLoading2 } = useMutation({
  mutationFn: async (contactData) => {
    await contactStore.createContacts(contactData);
    $q.notify({
            color: 'blue-4',
            textColor: 'white',
            icon: 'cloud_done',
            message: 'Contact Created'
          })
  },
});
const { mutate: deleteContact } = useMutation({
  mutationFn: async (contactId) => {
    // Dispatch action to create contact in Vuex store
    await contactStore.deleteContacts(contactId);
            $q.notify({
            color: 'blue-4',
            textColor: 'white',
            icon: 'cloud_done',
            message: 'Contact Deleted'
          })
  },
});

const { mutate: updateContact } = useMutation({
  mutationFn: async ({ contactId, contactData }) => {
    // Dispatch action to update contact in Vuex store
    await contactStore.updateContacts(contactId, contactData);
    console.log("we here", contactId, contactData);
            $q.notify({
            color: 'blue-4',
            textColor: 'white',
            icon: 'cloud_done',
            message: 'Contact Updated'
          })
  },
});
const selectedContactId = ref(null);

const onUpdate = (row) => {
  selectedContactId.value = row.id;
  fname.value = row.first_name;
  lname.value = row.last_name;
  email.value = row.email;
  phoneno.value = row.phone_number;
  address.value = row.address;
}

const onDelete = async (row) => {
  console.log('Delete row:', row.id)
  await deleteContact(row.id);
}
const onSubmit = async () => {
  const contactData = {
    first_name: fname.value,
    last_name: lname.value,
    email: email.value,
    phone: phoneno.value,
    address: address.value,
    group_id: group.value,
  };

if (selectedContactId.value!==null) {
  const contactData = {
    first_name: fname.value,
    last_name: lname.value,
    email: email.value,
    phone: phoneno.value,
    address: address.value,
    group_id: group.value,
  };
 const contactId = selectedContactId.value;
  await updateContact({ contactId, contactData });
    
} else {
await createContact(contactData);
  
}

selectedContactId.value = null;
  onReset();
};

     const onReset = () => {
      fname.value = '';
  lname.value = '';
  email.value = '';
  phoneno.value = '';
 address.value = '';
    }   

</script>
<style>
.q-dense .q-field {
  padding: 0;
  margin: 0.5px;
}
.q-dense .q-field__control {
  min-height: auto;
}
.q-dense .q-input-target {
  padding-top: 4px;
  padding-bottom: 4px;
}
</style>
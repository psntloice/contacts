import { defineStore } from "pinia";
import { get_call_module, post_call_module, put_call_module, delete_call_module } from "src/utilities/module_calls";

export const useContactStore = defineStore("contacts", {
  state: () => ({
    allContacts: [],
    allGroups: [],
    // succPayments: [],
    // pendingPayments: [],
    // amount: [],
    // codeResponse: [],
    // sevenDaypayments: [],
  }),

  actions: {
    async fetchContacts() {
      const res = await get_call_module("contacts");
    
  
      this.allContacts =res?.data;
      console.log("rtyu c", res?.data);
      return this.allContacts;
    },
    async createContacts(cont) {
      const res_create_contacts = await post_call_module(cont,"contacts");

      return res_create_contacts;
    },

    async updateContacts(tid, cont) {
      const res_update_contacts = await put_call_module(cont,"contacts", tid);
console.log("heyo");
      return res_update_contacts;
    },
    async deleteContacts(tid) {
      const res_delete_contacts = await delete_call_module("contacts",tid);

      return res_delete_contacts;
    },
    async fetchGroups() {
      const resw = await get_call_module("groups");

      this.allGroups = resw?.data;
      console.log("rtyu fg", this.allGroups);
      return this.allGroups;
    },
    async createGroups(cont) {
      const res_create_group = await post_call_module(cont,"contacts");

      return res_create_group;
    },

    async updateGroups(tid,cont) {
      const res_update_group = await put_call_module(cont,"groups", tid);

      return res_update_group;
    },

    async deleteGroups(tid) {
      const res_delete_group = await delete_call_module("groups",tid);

      return res_delete_group;
    },
    async addContacts() {
      const resw = await get_call_module("groups");

      this.allGroups = resw;
      console.log("rtyu g", this.allGroups);
      return this.allGroups;
    },
    async removeContacts() {
      const resw = await get_call_module("groups");

      this.allGroups = resw;
      console.log("rtyu g", this.allGroups);
      return this.allGroups;
    },
  },
});

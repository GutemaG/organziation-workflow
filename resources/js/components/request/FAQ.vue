<template>
  <div class="container">
    <b-row>
      <b-col lg="6" class="my-1">
        <b-form-group
          label="Add"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-3"
        >
          <b-button size="sm" @click="addFAQ" class="mr-1" variant="primary">
            + {{ tr("Add") }}
          </b-button>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1"> </b-col>

      <b-col lg="6" class="my-1">
        <b-form-group
          label="Filter"
          label-for="filter-input"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-0"
        >
          <b-input-group size="sm">
            <b-form-input
              id="filter-input"
              v-model="filter"
              type="search"
              placeholder="Type to Search"
            ></b-form-input>

            <b-input-group-append>
              <b-button :disabled="!filter" @click="filter = ''">{{
                tr("Clear")
              }}</b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1"> </b-col>

      <b-col sm="5" md="6" class="my-1">
        <b-form-group
          :label="tr('Per page')"
          label-for="per-page-select"
          label-cols-sm="6"
          label-cols-md="4"
          label-cols-lg="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-0"
        >
          <b-form-select
            id="per-page-select"
            v-model="perPage"
            :options="[15, 10, 5, 3, 1]"
            size="sm"
          ></b-form-select>
        </b-form-group>
      </b-col>

      <b-col sm="7" md="6" class="my-1">
        <b-pagination
          v-model="currentPage"
          :total-rows="faqs.length"
          :per-page="perPage"
          align="fill"
          size="sm"
          class="my-0"
          :first-text="tr('First')"
          :prev-text="tr('Prev')"
          :next-text="tr('Next')"
          :last-text="tr('Last')"
        ></b-pagination>
      </b-col>
    </b-row>
    <b-table
      :items="faqs"
      :fields="fields"
      stacked
      striped
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :filter-included-fields="filterOn"
    >
      <template #cell(id)="row">
        {{ row.index + 1 }}
      </template>
      <template #cell(actions)="row">
        <b-button
          size="sm"
          class="mr-1"
          variant="primary"
          @click="editFQA(row.item, row.index, $event.target)"
        >
          <i class="fa fa-edit">{{ tr("Edit") }}</i>
        </b-button>
        <b-button
          size="sm"
          @click="deleteFAQ(row.item)"
          class="mr-1"
          variant="danger"
        >
          <i class="fa fa-trash">{{ tr("Delete") }}</i>
        </b-button>
      </template>
    </b-table>
    <edit-faq-modal></edit-faq-modal>
    <add-faq-modal></add-faq-modal>
  </div>
</template>

<script>
import EditFAQModal from './faq/EditFAQModal.vue'
import AddFAQModal from './faq/AddFAQModal.vue'
export default {
  name: "faq-page",
  components:{
      'edit-faq-modal':EditFAQModal,
      'add-faq-modal':AddFAQModal
  },
  data() {
    return {
      faqs: [],
      fields: [
        {
          key: "id",
          label: "#",
        },
        {
          key: "question",
          label: "Question",
        },
        {
          key: "answer",
          label: "Answer",
        },
        {
          key: "created_at",
          label: "Created At",
        },
        {
          key: "actions",
          label: "Actions",
        },
      ],
      totalRows: 1,
      currentPage: 1,
      perPage: 1,
      pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
      filter: null,
      filterOn: [],
      selectedUser: {},
    };
  },
  methods: {
    async fetchFAQ() {
      let resp = await axios.get("/api/faqs");
      if (resp.data.status == 200) {
        this.faqs = resp.data.faqs;
      } else {
        console.log("something is wrong");
      }
      //   .then((resp) => console.log(resp.data));
    },
    deleteFAQ(item) {
        console.log('deleting')
    },
    addFAQ() {
      this.$root.$emit("bv::show::modal", "add-faq-modal");
    },
    editFQA() {
      this.$root.$emit("bv::show::modal", "edit-faq-modal");

    },
  },
  created() {
    this.fetchFAQ();
  },
};
</script>
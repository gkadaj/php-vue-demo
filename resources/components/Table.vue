<template>
    <div>
      <v-alert
          v-if="deleteError"
          type="error"
          dismissible
          @input="deleteError = ''"
      >
        {{ deleteError }}
      </v-alert>
      <v-data-table
          :headers="headers"
          :items="cars"
          :items-per-page="5"
          class="elevation-1"
      >
        <template v-slot:item.actions="{ item }">
          <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
          <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
        </template>
      </v-data-table>

      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>Edit Vehicle</v-card-title>
          <v-alert
              v-if="editError"
              type="error"
              dismissible
              @input="editError = ''"
          >
            {{ editError }}
          </v-alert>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-text-field v-model="editedItem.registrationNumber" label="Registration Number"
                                maxlength="255"></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field v-model="editedItem.brand" label="Brand" maxlength="255"></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field v-model="editedItem.model" label="Model" maxlength="255"></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field v-model="editedItem.type" label="Vehicle Type" maxlength="255"></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
            <v-btn color="blue darken-1" text @click="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      cars: [],
      dialog: false,
      deleteError: '',
      editError: '',
      editedItem: {
        id: '',
        registrationNumber: '',
        brand: '',
        model: '',
        type: '',
        updatedAt: ''
      },
      headers: [
        {text: 'No.', value: 'id'},
        {text: 'Registration Number', value: 'registrationNumber'},
        {text: 'Brand', value: 'brand'},
        {text: 'Model', value: 'model'},
        {text: 'Vehicle Type', value: 'type'},
        {text: 'Creation Date', value: 'createdAt'},
        {text: 'Modification Date', value: 'updatedAt'},
        {text: 'Actions', value: 'actions', sortable: false}
      ]
    }
  },
  methods: {
    editItem(item) {
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },
    deleteItem(item) {
      if (confirm('Are you sure you want to delete this item?')) {
        axios.post(`http://localhost:8008/vehicles/delete/${item.id}`)
            .then(() => {
              const index = this.cars.indexOf(item)
              this.cars.splice(index, 1)
              this.deleteError = ''
            })
            .catch(error => {
              this.deleteError = 'Failed to delete vehicle: ' + (error.response?.data || error.message)
            })
      }
    },
    close() {
      this.dialog = false
      this.editError = ''
      this.editedItem = {
        id: '',
        registrationNumber: '',
        brand: '',
        model: '',
        type: '',
        updatedAt: ''
      }
    },
    save() {
      axios({
        method: 'post',
            url: `http://localhost:8008/vehicles/save/${this.editedItem.id}`,
            data:  this.editedItem,
            headers: {
              'Content-Type': 'text/plain;charset=utf-8',
            },
      }).then(response => {
        const obj = JSON.parse(response.data[1]);
        const index = this.cars.findIndex(item => item.id === this.editedItem.id);
        this.editedItem.brand = obj.brand;
        this.editedItem.model = obj.model;
        this.editedItem.type = obj.type;
        this.editedItem.registrationNumber = obj.registrationNumber;
        this.editedItem.updatedAt = obj.updatedAt;
        Object.assign(this.cars[index], this.editedItem)
        this.close()
      }).catch(error => {
        this.editError = 'Failed to save vehicle: ' + (error.response?.data || error.message)
      })
    }
  },
  mounted() {
    axios
        .get('http://localhost:8008/vehicles/list')
        .then(response => {
          let carsResponseData = [];
          for (let i = 0; i < response.data.results.length; i++) {
            let car = response.data.results[i];
            carsResponseData.push({
              id: car.id,
              registrationNumber: car.registrationNumber,
              brand: car.brand,
              model: car.model,
              type: car.type,
              createdAt: car.createdAt,
              updatedAt: car.updatedAt
            })
          }
          this.cars = carsResponseData;
        })
        .catch(error => {
          console.log(error)
          this.cars = [];
        })
  }
}
</script>

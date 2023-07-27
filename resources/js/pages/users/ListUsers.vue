<script setup>
import axios from 'axios';
import { ref, reactive, onMounted } from 'vue';
import { Form, Field } from 'vee-validate';
import * as yup from 'yup';

    const users = ref([]);
    const editing = ref(false);
    const formValues = ref();
    const form = ref(null);

    // const form = reactive({
    //     name: '',
    //     email: '',
    //     password: '',
    // });

    const getUsers = () => {
        axios.get('/api/users')
        .then((response) => {
            users.value = response.data;
        })
    }
    

    const createUserSchema = yup.object({
        name: yup.string().required(),
        email: yup.string().email().required(),
        password: yup.string().required().min(4),
    });

    const editUserSchema = yup.object({
        name: yup.string().required(),
        email: yup.string().email().required(),
        // password: yup.string().when((password, schema) => {
        //     return password ? schema.required().min(4) : schema;
        // }),
    });

    // const createUser = (values, { resetForm, setFieldError }) => {
    const createUser = (values, { resetForm, setErrors }) => {
        axios.post('/api/users', values)
        .then((response)=>{
            users.value.unshift(response.data);
            $('#newUser').modal('hide');
            resetForm();
        })
        .catch((error) => {
            // setFieldError('email',error.response.data.errors.email[0])
            if(error.response.data.errors){
                setErrors(error.response.data.errors)
            }
            
        })
    };

    const addUser = () => {
        editing.value = false;
        $('#newUser').modal('show');
    }

    const editUser = (user) => {
        editing.value = true;
        form.value.resetForm();
        $('#newUser').modal('show');
        formValues.value = {
            id: user.id,
            name: user.name,
            email: user.email
        };
    }
    const updateUser = (values, {setErrors}) => {
        axios.put('/api/users/' + formValues.value.id, values)
        .then((response)=>{
            const index = users.value.findIndex(user => user.id === response.data.id);
            users.value[index] = response.data;
            $('#newUser').modal('hide');
        }).catch((error) => {
            setErrors(error.response.data.errors);
            console.log();
        })
    }
    const handleSubmit = (values, actions) => {
        if (editing.value) {
            updateUser(values, actions);
        } else {
            createUser(values, actions);
        }
    }

    onMounted(()=>{
        getUsers();
    });

    // const createUser = () => {
    //     axios.post('/api/users', form)
    //     .then((response)=>{
    //         // users.value.push(response.data);//last
    //         users.value.unshift(response.data);
    //         form.name = '';
    //         form.email = '';
    //         form.password = '';
    //         $('#newUser').modal('hide');
    //     });
    // }
    // const users = [
    //     {
    //         id: 1,
    //         name:'Arif Islam',
    //         email: 'arif@gmail.com'
    //     },
    //     {
    //         id: 2,
    //         name:'Ayesha Islam',
    //         email: 'ayssha@gmail.com'
    //     }
    // ];
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users List</h3>
                <button @click="addUser" type="button" class="btn btn-primary btn-sm float-right">
                    <ion-icon name="add-circle-outline"></ion-icon> New user
                </button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users" :key="user.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>
                                    <a href="#" @click.prevent="editUser(user)"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newUser">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">
                <span v-if="editing">Edit User</span>
                <span v-else>Add New User</span>
              </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editUserSchema : createUserSchema" v-slot="{ errors }" :initial-values="formValues">
            <div class="modal-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <!-- <input v-model="form.name" type="text" class="form-control" id="name" name="name" placeholder="Enter name"> -->
                    <Field type="text" name="name" class="form-control" :class="{ 'is-invalid': errors.name }" id="name" placeholder="Enter name" />
                    <span class="invalid-feedback">{{ errors.name }}</span>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <Field type="email" name="email" class="form-control" :class="{ 'is-invalid': errors.email }" id="email" placeholder="Enter email" />
                    <span class="invalid-feedback">{{ errors.email }}</span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <Field type="text" name="password" class="form-control" :class="{ 'is-invalid': errors.password }" id="password" placeholder="Enter password" />
                    <span class="invalid-feedback">{{ errors.password }}</span>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
              <!-- <button @click="createUser" type="button" class="btn btn-primary">Save</button> -->
            </div>
            </Form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
</template>
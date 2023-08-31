<script setup>
import axios from 'axios';
import { ref, reactive, onMounted, watch } from 'vue';
import { Form, Field } from 'vee-validate';
import * as yup from 'yup';
import { useToastr } from '../../toastr.js';
// import moment from 'moment';

import UserListItem from './UserListItem.vue';

import { debounce } from 'lodash';

import { Bootstrap4Pagination } from 'laravel-vue-pagination';


    const toastr = useToastr();
    const users = ref({'data':[]});
    const editing = ref(false);
    const formValues = ref();
    const form = ref(null);
   

    // const form = reactive({
    //     name: '',
    //     email: '',
    //     password: '',
    // });

    const getUsers = (page = 1) => {
        axios.get(`/api/users?page=${page}`)
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
            toastr.success("User successfully created!");
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
            toastr.success("User successfully updated!");
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

    const userDeleted = (userId) => {
        users.value = users.value.filter(user => user.id !== userId);
    }

    const searchQuery = ref(null);

    const search =()=>{
        axios.get('/api/users/search', {
            params: {
                query: searchQuery.value
            }
        })
        .then(response => {
            users.value = response.data;
        })
        .catch(error => {
            console.log(error);
        })
    }

    watch(searchQuery, debounce(()=>{
        search();
    }, 300));

    onMounted(()=>{
        getUsers();
        // toastr.info('Success');
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
                    <!-- <h3 class="card-title">Users List</h3> -->
                    <div class="d-flex justify-content-between">
                        <button @click="addUser" type="button" class="btn btn-primary btn-sm float-right">
                            <ion-icon name="add-circle-outline"></ion-icon> New user
                        </button>
                        <div>
                            <input type="text" v-model="searchQuery" class="form-control" placeholder="Search..."/>
                        <!-- <button @click.prevent="search">submit</button> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="users.data.length > 0">
                            <UserListItem v-for="(user, index) in users.data"
                                :key="user.id"
                                :user=user
                                :index = index
                                @edit-user = "editUser"
                                @user-deleted = "userDeleted"
                             />
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="6" class="text-center">No result found..</td>
                            </tr>
                        </tbody>
                    </table>
                        
                </div>
                <Bootstrap4Pagination
                        :data="users"
                        @pagination-change-page="getUsers"
                        />
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
        </div>
      </div>
    
</template>
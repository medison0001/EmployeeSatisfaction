import axios from 'axios';

export const createEmployee = async (employee) => {
    const response = await axios.post('http://localhost:8000/api/employees', employee);
    return response.data;
};

export const areOptionsEmpty = (options) => { 
    return options.length === 0;
};

export const userRolesUpdated = (Swal) => { 
    Swal.fire({
        icon: 'success',
        title: 'User roles updated',
        text: 'The user roles have been updated successfully',
    });
};

export const emptyOptionsError = (Swal) => { 
    Swal.fire({
        icon: 'error',
        title: 'Empty Error',
        text: 'The user should have at least one rol, please select at least one option',
    });
};


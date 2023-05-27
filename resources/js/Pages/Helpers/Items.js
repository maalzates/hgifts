
export const isAnyFieldEmpty = (item_form) => {
    for (let key in item_form) {
      if (item_form[key] === '') {
        return true; // Found an empty property
      }
    }
    return false; // No empty properties found
};

export const emptyError = (Swal) => {
    Swal.fire({
        icon: 'error',
        title: 'Empty Field Error',
        text: 'One or more inputs  are empty, fill them all'
    })
};

export const itemCreated = (Swal) => {
    Swal.fire({
        icon: 'success',
        title: 'Item Created',
        text: 'The item has been successfully created.',
    });
};

export const itemUpdated = (Swal) => {
    Swal.fire({
        icon: 'success',
        title: 'Item Updated',
        text: 'The item has been successfully updated.',
    });
};

export const itemDeleted = (Swal) => {
    Swal.fire({
        icon: 'success',
        title: 'Item Deleted',
        text: 'The item has been successfully Deleted.',
    });
};
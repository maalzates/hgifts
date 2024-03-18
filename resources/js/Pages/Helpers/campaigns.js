export const isAnyFieldEmpty = (form) => { 
    // Iterate over the object properties
    for (let key in form) {
        if (form.hasOwnProperty(key)) {
        const value = form[key];
            // Check if the value is an empty string or empty array
            if (value === '' || (Array.isArray(value) && value.length === 0)) {
                return true;
            }
        }
    }
    // No empty values found
    return false;
};

export  const areDuplicatedItems = (form_items) => {
    // Checking if the items selected are repeated

    //Creating copy of original array and getting it id's
    let items_array = [...form_items].map( (item) => item.item_id);
    // Checks if the index of the current item is different from its first occurrence in the array, indicating that it is a repeated item.
    let are_repeated_items = items_array.some( (item, index) => items_array.indexOf(item) != index);
    return are_repeated_items;
};

export const isNameOrAmountEmpty = (form_items) =>{
    // Check if some of  the selected items is empty
    let items_array = [...form_items];
    let validation = items_array.some((item) => Object.values(item).some( value => value === "" ));
    console.log(items_array);
    return validation;
};

export const isCommentEmpty = (comment) => { 
    return comment === '';
 }
export const repeatedError = (Swal) => {
    Swal.fire({
        icon: 'error',
        title: 'Repeated Item Found',
        text: 'Avoid selecting a repeated item, if you need more of one item, please increase the AMOUNT field.'
    })
};

export const emptyError = (Swal) => {
    Swal.fire({
        icon: 'error',
        title: 'Add Items Error',
        text: 'Please make sure ITEM and COUNT fields are filled for ALL items.'
    })
};

export const fieldsEmptyError = (Swal) => { 
    Swal.fire({
        icon: 'error',
        title: 'Empty fields Errorr',
        text: 'All fileds are required, please fill them all'
    })
};

export const campaignCreated = (Swal) => { 
    Swal.fire({
        icon: 'success',
        title: 'Campaign was created',
        text: 'The campaign has been successfully created',
    });
};

export const campaignUpdatedPopup = (Swal) => { 
    Swal.fire({
        icon: 'success',
        title: 'Campaign Updated',
        text: 'The campaign has been successfully updated',
    });
};

export const campaignDeltedPopup = (Swal) => { 
    Swal.fire({
        icon: 'success',
        title: 'Campaign Deleted',
        text: 'The campaign has been successfully deleted',
    });
};

export const commentAddedPopup = (Swal) => { 
    Swal.fire({
        icon: 'success',
        title: 'Comment Added',
        text: 'The comment has been successfully added',
    });
};

export const emptyCommentError = (Swal) => { 
    Swal.fire({
        icon: 'error',
        title: 'Empty fields Errorr',
        text: 'The comment should not be empty, write a comment.'
    })
}
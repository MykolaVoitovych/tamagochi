import { primary as primaryRequest } from './requests'

export const loadList = function (formData) {
    return primaryRequest.get(
        route('pets.index', formData)
    )
}

export const load = function (id) {
    return primaryRequest.get(
        route('pets.show', { id })
    )
}

export const store = function (options) {
    return primaryRequest.post(
        route('pets.store'),
        options
    )
}

export const update = function (id, options) {
    return primaryRequest.put(
        route('pets.update', id),
        options
    )
}

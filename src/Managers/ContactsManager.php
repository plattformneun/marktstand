<?php

namespace Marktstand\Managers;

use Illuminate\Foundation\Auth\User;
use Marktstand\Company\Contact;

class ContactsManager extends Manager
{
    /**
     * Create a new contact.
     *
     * @param array $data
     * @param Illuminate\Foundation\Auth\User $user
     * @return Marktstand\Company\Contact
     */
    public function create(array $data, User $user)
    {
        $contact = new Contact;

        $this->makeFillable($contact)->fill(array_merge($data, [
            'user_id' => $user->id,
            'user_type' => $user->type,
        ]))->save();

        return $contact;
    }

    /**
     * Get the users contacts.
     *
     * @param  Illuminate\Foundation\Auth\User $user
     * @return Illuminate\Support\Collection
     */
    public function fromUser(User $user)
    {
        return $user->contacts;
    }

    /**
     * Find the contact by id.
     *
     * @param  int $id
     * @return Marktstand\Company\Contact
     */
    public function fromId($id)
    {
        return Contact::findOrFail($id);
    }

    /**
     * Update the given contact.
     *
     * @param  Marktstand\Company\Contact $contact
     * @param  array $data
     * @return Marktstand\Company\Contact
     */
    public function update(Contact $contact, array $data)
    {
        $this->makeFillable($contact)->update($data);

        return $contact;
    }

    /**
     * Define the fillable fields.
     *
     * @return array
     */
    protected function fillable()
    {
        return [
            'position', 'gender', 'firstname', 'lastname', 'email', 'user_id', 'user_type',
        ];
    }
}

<?php

namespace Marktstand\Managers;

use Marktstand\Company\Contact;

trait ContactsManager
{
    /**
     * Add a new contact.
     *
     * @param Illuminate\Foundation\Auth\User $user
     * @param array $data
     * @return Marktstand\Company\Contact
     */
    public function addContact($user, array $data)
    {
        $contact = new Contact;

        $this->makeContactFillable($contact)->fill(array_merge($data, [
            'user_id' => $user->id,
            'user_type' => $user->type,
        ]))->save();

        return $contact;
    }

    /**
     * Update the given contact.
     *
     * @param  Marktstand\Company\Contact $contact
     * @param  array $data
     * @return Marktstand\Company\Contact
     */
    public function updateContact(Contact $contact, array $data)
    {
        $this->makeContactFillable($contact)
            ->update($data);

        return $contact;
    }

    /**
     * Set fillable fields for the given contact.
     *
     * @param  Marktstand\Company\Contact $contact
     * @return Marktstand\Company\Contact
     */
    public function makeContactFillable(Contact $contact)
    {
        return $this->setFillable($contact, [
            'position', 'gender', 'firstname', 'lastname', 'email', 'user_id', 'user_type',
        ]);
    }
}

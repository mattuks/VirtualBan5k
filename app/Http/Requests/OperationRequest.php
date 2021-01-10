<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'receiver_uuid' => 'required|exists:accounts,uuid',
            'amount' => 'required|numeric|regex:/^[+]?\d+([.]\d+)?$/m'
        ];
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->get('id');
    }

    /**
     * @return string
     */
    public function receiverUUID(): string
    {
        return $this->get('receiver_uuid');
    }

    /**
     * @return string
     */
    public function senderUUID(): string
    {
        return $this->get('sender_uuid');
    }

    /**
     * @return string
     */
    public function amount(): string
    {
        return $this->get('amount');
    }
    /**
     * @return string
     */
    public function currency(): string
    {
        return $this->get('currency');
    }

}

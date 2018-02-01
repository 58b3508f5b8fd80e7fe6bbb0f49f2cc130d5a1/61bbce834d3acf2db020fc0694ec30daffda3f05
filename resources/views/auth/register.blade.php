@extends('layouts.auth')
@section('title', 'Join')
@section('content')
    <div class="py-30 px-5 text-center">
        <a class="link-effect font-w700" href="index-2.html">
            <i class="si si-fire"></i>
            <span class="font-size-xl text-primary-dark">{{config('app.name')}}</span>
        </a>
        <h1 class="h2 font-w700 mt-50 mb-10">Create New Account</h1>
        <h2 class="h4 font-w400 text-muted mb-0">Please add your details</h2>
    </div>
    <div class="row justify-content-center px-5">
        <div class="col-sm-8 col-md-6 col-xl-4">
            <form class="js-validation-signup" action="{{url('/register')}}"
                  method="post">
                <input type="hidden" name="_method" value="PUT">
                {{csrf_field()}}
                <input name="find" type="hidden" value="{{session('user')->id+1147}}">
                <div class="form-group{{ $errors->has('account') ? ' is-invalid' : '' }}  row">
                    <div class="col-6 col-xs-4">
                        <div class="form-material floating">
                            <input class="form-control" id="name" name="acc_number" type="text"
                                   value="{{session('user')->account_number}}" readonly>
                            <label for="name">Account Number</label>
                        </div>
                    </div>
                    <div class="col-6 col-xs-8">
                        <div class="form-material floating">
                            <input class="form-control" id="name" name="wallet" type="text"
                                   value="{{session('user')->wallet_address}}" readonly>
                            <label for="name">Wallet Address</label>
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}  row">
                    <div class="col-12">
                        <div class="form-material floating">
                            <input class="form-control" id="name" name="name" type="text" value="{{old('name')}}"
                                   required>
                            <label for="name">Username</label>
                        </div>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>

                </div>
                <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }} row">
                    <div class="col-12">
                        <div class="form-material floating">
                            <input class="form-control" id="email" name="email" type="email" value="{{old('email')}}"
                                   required>
                            <label for="email">Email</label>
                        </div>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }} row">
                    <div class="col-6">
                        <div class="form-material floating">
                            <input class="form-control" id="password" name="password" type="password" required>
                            <label for="password">Password</label>
                        </div>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-6">
                        <div class="form-material floating">
                            <input class="form-control" id="password-confirm" name="password_confirmation"
                                   type="password" required>
                            <label for="password-confirm">Confirm Password</label>
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('pin') ? ' is-invalid' : '' }} row">
                    <div class="col-6">
                        <div class="form-material floating">
                            <input class="form-control" id="pin" name="pin" type="password" maxlength="4" required>
                            <label for="pin">Pin</label>
                        </div>
                        @if ($errors->has('pin'))
                            <span class="invalid-feedback">
                                {{ $errors->first('pin') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-6">
                        <div class="form-material floating">
                            <input class="form-control" id="pin-confirm" name="pin_confirmation"
                                   type="password" required>
                            <label for="pin-confirm">Confirm Pin</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row text-center">
                    <div class="col-12">
                        <label class="css-control css-control-primary css-checkbox">
                            <input class="css-control-input" id="signup-terms" name="signup-terms" type="checkbox"
                                   required>
                            <span class="css-control-indicator"></span>
                            I agree to Terms & Conditions
                        </label>
                    </div>
                </div>
                <div class="form-group row gutters-tiny">
                    <div class="col-12 mb-10">
                        <button type="submit" class="btn btn-block btn-hero btn-noborder btn-rounded btn-alt-success">
                            <i class="si si-user-follow mr-10"></i> Register
                        </button>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-block btn-noborder btn-rounded btn-alt-secondary" href="#" data-toggle="modal"
                           data-target="#modal-terms">
                            <i class="si si-book-open text-muted mr-10"></i> Read Terms
                        </a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-block btn-noborder btn-rounded btn-alt-secondary" href="op_auth_signin.html">
                            <i class="si si-login text-muted mr-10"></i> Sign In
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-labelledby="modal-terms"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-slidedown" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Terms &amp; Conditions</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        Touching Lives Skills Limited will never ask you for your access codes (User ID, Password/PIN)
                        in any way (e.g. via phone or e-mail). These codes are strictly personal and you must never
                        reveal them to anyone.
                        Keep the access codes (User/Corporate ID, Password/PIN) confidential in a way that is not
                        feasible for them to be disclosed/stolen.
                        Sign on to Touching Lives Skills Limited Internet Savings Service only via Touching Lives Skills
                        Limited's website, (www.tlsavings.xyz), and never via other links appearing on other websites,
                        search engines or e-mail messages.
                        Update your PC with the latest versions and security patches of the operating system (e.g.
                        Windows) and the browser (e.g. Internet Explorer, Firefox).
                        Regularly inspect your PC for viruses and other malicious programs using the latest versions of
                        antivirus and antimalware utilities.
                        ATTENTION: There are malicious programs which could be installed unintentionally on your PC,
                        with the objective of stealing Login Details. If, during your sign-on to Touching Lives Skills
                        Limited Internet Savings, you notice any “unusual” messages that encourage you to re – enter
                        your access codes, stop the procedure, Call our Customer Service Department on +234 706 533 7887
                        or + 234 813 237 9639 have your PC cleaned from viruses and other malicious software from which
                        it may have been infected.
                        Ignore and immediately delete suspicious e-mails that ask you to provide your personal data,
                        including links or attachments. Do not open the attachments.
                        Touching Lives Skills Limited Internet Savings webpage will not ask you to enter personal or
                        account information during the login process or for any Internet Savings pages where the
                        information requested is not relevant to the transaction. If you are prompted to do so, DO NOT
                        enter the requested information and contact us immediately.
                        Click OK to continue to Touching Lives Skills MPCS (Abak) Limited Internet Savings Service
                        webpage. By clicking OK, you accept usage of the Internet Savings Service subject to the
                        Cooperatives’ Internet Savings Terms and Conditions.
                        TOUCHING LIVES SKILLS MPCS LIMITED
                        INTERNET SAVINGS TERMS AND CONDITIONS
                        INTRODUCTION:
                        These terms and conditions (hereinafter referred to as “these Terms and Conditions”) apply to
                        the use of our internet savings services. These Terms and Conditions enumerates the
                        Customer’s/member’s rights and responsibilities and those of Touching Lives Skills MPCS Limited
                        regarding the use of our Internet Savings services.
                        All products and services provided by the Cooperative are subject to their own specific terms
                        and conditions (“product agreements”) and to the Cooperative’s General Terms and Conditions
                        signed by the Customer/member at the time the Customer/member opens a Savings Account;
                        These Terms and Conditions shall be read in conduction with the aforesaid product agreements as
                        well as the General Terms and Conditions.
                        The Customer /member hereby agrees to comply with and be bound by these Terms and Conditions and
                        recognizes that these Terms and Conditions are without prejudice to any right that the
                        Cooperative may have with respect to the Savings Account in law or otherwise.
                        Definitions and Interpretation
                        1.1. In these Terms and Conditions, unless the context otherwise requires:
                        a) “We”, “us”, “our”, “the Cooperative” means Touching Lives Skills MPCS Limited, incorporated
                        in Akwa Ibom State Nigeria as a limited liability company under the Akwa Ibom State Co-operative
                        Societies Law cap 35 of 2002 (Section 50 of the Regulations) and licensed to carry on savings
                        scheme to members and non-members under the Akwa Ibom State Co-operative Societies Law cap 35 of
                        2002 in the State aforesaid and includes such Agents or Subsidiaries of the Cooperative as may
                        from time to time be specified by the Cooperative to the Customer;
                        b) “Saving Day” means a day on which the counters of the Office and/or Cooperatives Subsidiary
                        offices (as applicable) are open for the transaction of ordinary business;
                        c) “Savings Subsidiary” means the subsidiary or subsidiaries or the Cooperative which may from
                        time to time be specified by the Cooperative to the Customer;
                        d) “Agents” means an Agent or Agents of the Cooperative by franchise which may from time to time
                        be specified by the Cooperative to the Customer;
                        e) “Savings Account” means the Member’s/Customer’s fixed savings, special savings, thrift
                        savings and savings deposit account(s) shares and term and call deposit account(s) (as the case
                        may be) with the Cooperative;
                        f) “You”, “your”, “the Customer” “the member” means the Cooperative’s Customer who is operating
                        an active Savings Account on which the Service is available.
                        g) “Customer Group” means the Customer and where the Customer is a company; its holding company
                        (if any) and their respective subsidiaries from time to time;
                        h) “Corporate Administrator” means the person appointed by the account signatories of a Savings
                        Account held by a corporate Customer, to create other internet Savings operators.
                        i)“Corporate User/Maker” means the internet Savings operator created by the Corporate
                        Administrator with System rights to create or initiate Requests (whether for payments or other
                        requests) on the System.
                        j) “Corporate Dual User” means internet savings operator created by the Corporate Administrator
                        with System rights to create or initiate as well as authorize Requests (whether for payments or
                        other requests) on the System.
                        k) “Corporate Authorizer/Checker” means internet savings operator created by the Corporate
                        Administrator with System rights to authorize Requests (whether for payments or other requests).
                        l) “Deposit Account” means a savings Account with an available credit balance;
                        m) “General Terms and Conditions” means the Cooperative’s General Terms and Conditions signed by
                        the Customer at the time the Customer opens a savings Account;
                        n) “Nominated User/s” means the representative or representatives of the Customer authorized by
                        the Customer to hold and change the Password/PIN and hence to access the System and Service on
                        behalf of the Customer;
                        o) “Password/PIN” means the secret password known only to the Customer or the Customer’s
                        Nominated User for the access to the System. The Customer or its nominated user may change the
                        password/PIN at will;
                        p) “Request” means a request or instruction received by the Cooperatives from the Customer or
                        purportedly from the Customer through the System and upon which the Cooperative is, by virtue or
                        subparagraph 6.1, authorized to act;
                        q) “Service” means such of the internet savings services, offered by the Cooperative which may
                        be collectively branded by a product name, as the Customer may from time to time subscribe for;
                        r) “System” means the electronic savings and communications software enabling the Customer to
                        communicate with the Cooperative for the purpose of the Service. The System and Service will for
                        the purpose of these Terms and Conditions be accessed through the internet via the Cooperative’s
                        website, www.tlsavings.xyz; and
                        s) “Application/Subscription” means application/subscription for the internet savings service by
                        a Customer;
                        t) “User ID” means a unique identifier of the Customer in the System and typically, it is the
                        retail Customer’s Customer Identification File (CIF) as recorded in the Cooperative’s core
                        savings system;
                        u) “Corporate ID” means a unique identifier of the corporate Customer in the System and
                        typically, it is the corporate Customer’s Customer Identification File (CIF) as recorded in the
                        Cooperative’s core savings system;
                        v) “Empowerment fund” means a unique cash deposit or transfer that comes in form of grant or
                        loan issued to the customer’s savings account by a corporate/government body or a group or
                        person.
                        w) “Personal Fund” means any cash deposit or transfer made by the customer to his savings
                        account.
                        1.2. In these Terms and Conditions:
                        Where “the Customer” is more than one person, references to “the Customer” shall include all
                        and/or any of such persons and the obligations of the Customer shall be joint and several;
                        Words in the singular shall include the plural and vice versa and words importing any gender
                        shall include all other genders;
                        Reference to the Cooperative shall where the context so admits include its successors and
                        assigns.
                        2. Application/Subscription by the Customer
                        2.1. In consideration of the customer paying to the Cooperative the fees and charges set out in
                        the subparagraph 9.1, the Cooperative shall provide to the Customer certain internet savings
                        services subject to and in accordance with these Terms and Conditions.
                        2.2 The Customer will apply/subscribe for the Cooperative’s internet savings services by
                        completing an application form provided by the Cooperative. The Customer’s application for use
                        of the Service shall be subject to these Terms and Conditions.
                        2.3 Once the Cooperative has approved the Application and the Customer has been maintained in
                        the Cooperative’s records as an authorized user of the Service, the Cooperative will provide the
                        Customer with a User ID for retail Customers or Corporate ID for corporate Customers. The
                        Customer shall create their preferred Password/PIN known only to them, and this Password/PIN
                        along with their User ID or Corporate ID will allow them access for use of the Service.
                        2.4 Further additional internet savings services may be provided to the Customer by the
                        Cooperative, provided the Customer completes an application form in respect of such additional
                        services and the Cooperative reserves the right to modify, replace or withdraw any Service at
                        any time, for any reason whatsoever, without prior notice to the Customer.
                        2.5 Subject to subparagraph 2.2 The Customer’s application for and use of the Service shall also
                        be subject to any savings, term, shares and fixed accounts agreements (product agreements)
                        between the Cooperative and the Customer and the Cooperative’s General Terms and Conditions
                        signed by the Customer. Where there is any conflict between these Terms and Conditions and the
                        Cooperative’s General Terms and Conditions with regard to the use of Service, these Terms and
                        Conditions shall apply. Where there is any conflict between these Terms and Conditions and the
                        Cooperative’s General Terms and Conditions with regard to the Savings Account(s), the product
                        agreements and the General Terms and Conditions shall apply.
                        3. Joint accounts
                        3.1 Holders of joint accounts are jointly and severally liable under these Terms and Conditions.
                        Application for the Service made by any of the joint account holders acting alone as per
                        paragraph 2 above will be deemed to be binding on all the holders of the joint account(s). Each
                        joint account holder acting alone, under an assigned User ID and Password/PIN may use the
                        Service. The Cooperative shall not be required to obtain the consent of or notify any other
                        joint account holder(s) of the Requests. However, each joint account holder may access the
                        Service for the Savings account(s) for which they are joint owner using the assigned User ID and
                        Password.
                        3.2 Each joint account holder releases the Cooperative from any and all liability and agrees not
                        to make any claim or bring any action against the Cooperative for honouring or allowing any
                        Requests whether the person performing the transaction is one of the joint account holders or is
                        otherwise authorized to use the Service.
                        4. Corporate Customers
                        4.1 For corporate customers, the account signatories shall appoint a Corporate Administrator to
                        whom they shall grant the rights to create other internet savings operators.
                        4.2 The Corporate Administrator will be responsible for creating other internet Savings
                        operators (Corporate User(s)/Maker(s), Dual User(s), Authoriser(s)/Checker(s)) and assigning
                        them limits, as per approved authorization mandate by account signatories.
                        4.3 Any Requests received by the Cooperative through the System from Corporate User(s)/Maker(s),
                        Dual User(s), Authoriser(s)/Checker(s) as set-up by Corporate administrator as prescribed in
                        subparagraph 4.2 above will be considered to have come through the account signatories as per
                        operating mandate of the Savings Account.
                        5. Customer’s Facilities and Customer’s Responsibilities
                        5.1. The Customer shall at his/her/its own expense provide and maintain in safe and efficient
                        operating order such hardware, software and other facilities (including access to any public
                        telecommunications systems) and any communications network (collectively “the Facilities”)
                        necessary for the purpose of accessing the System and the Service.
                        5.2 The Customer shall be responsible for ensuring proper performance of the Facilities
                        including any losses or delays that may be caused by the Facilities. The Cooperative shall
                        neither be responsible nor liable for any errors or failures caused by any malfunction of the
                        Facilities nor shall the Cooperative be responsible or liable for any computer virus or related
                        problems that may be associated with the use of the System, the Service and the Facilities. The
                        Customer shall be responsible for charges due to any service provider providing the Customer
                        with connection to the electronic services and the Cooperative shall not be responsible or
                        liable for losses or delays caused by any such service provider.
                        5.3 The Customer shall obtain all licenses and consents necessary to have access to and use of
                        the System and shall ensure that all persons it allows to have access to the System shall comply
                        with all laws and regulations applicable to the use of the System and shall follow all
                        instructions, procedures and terms contained in these Terms and Conditions and any document
                        provided by the Cooperative concerning the use of the System and Service.
                        5.4 The Customer shall prevent any unauthorized access to or use of the System and Service by
                        keeping his/her/its User ID or Corporate ID (as the case may be) and Password/PIN secret at all
                        times. The Customer shall ensure that his/her/its User ID or Corporate ID (as the case may be)
                        and Password/PIN do not become known or come into possession of any unauthorized person.
                        5.5 The Customer shall take all reasonable and necessary precautions to detect any unauthorized
                        use of the System and Service. To that end, the Customer shall ensure that all communications
                        from the Cooperative are examined and checked by or on behalf of the Customer as soon as
                        practicable after receipt by the Customer in such a way that any unauthorized use of and access
                        to the System will be detected.
                        5.6 The Customer shall immediately inform the Cooperative by telephone with a written
                        confirmation sent the same day in the event that:
                        a) The Customer has reason to believe that any Password/PIN used by the Customer to gain access
                        to the Service and to communicate with the Cooperative is or may be known to any person not
                        authorized to know the same and/or been compromised; and/or
                        b) The Customer has reason to believe that unauthorized use of the Service has or may have
                        occurred or could occur and a transaction may have been fraudulently input or compromised.
                        5.7 The Customer shall not send or attempt to send any Request to the Cooperative through the
                        System if the Customer has reason to believe that for any reason such Request may not be
                        received by the Cooperative or may not be received accurately and intelligibly.
                        5.8 The Customer shall at all times follow the security procedures notified to the Customer by
                        the Cooperative from time to time or such other procedures as may be applicable to the Service
                        from time to time specifically those that may be contained on the Cooperative’s internet
                        website. The Customer acknowledges that any failure on the part of the Customer to follow the
                        recommended security procedures may result in a breach of the Customer’s profile confidentiality
                        and may lead to unauthorized transactions in account(s) linked to the Customer’s Service
                        application with the Cooperative. In particular, the Customer shall ensure that the Service is
                        not used or Requests are not issued or the relevant functions are not performed by anyone other
                        than a person authorized to do so.
                        5.9 The Customer shall not at any time operate or use the Service in any manner that may be
                        prejudicial to the Cooperative.
                        5.10 The Customer understands and accepts that it may link a business account or Bank Account
                        requiring multiple signatures to the Customer’s profile on this Service only if the Customer has
                        submitted to the Cooperative an original written standing mandate to the effect that the
                        Cooperative is authorized to process transactions not exceeding a certain specified amount, and
                        it will be the responsibility of the Customer to ensure that no unauthorized persons have access
                        to this Bank Account.

                        5.11. The Cooperative shall be entitled and authorized to debit the Customer’s savings Account
                        with the amounts of the transactions effected via the Service as well as debit the Customer’s
                        Savings Account with the amount of any fee applicable to the Service from time to time.
                        6. Irrevocable Authority of the Cooperative
                        6.1 The Cooperative is irrevocably authorized by the Customer to act on all Requests received by
                        the Cooperative from the Customer (or purportedly from the Customer) through the System and to
                        hold the Customer liable thereof, notwithstanding that any such requests are not authorized by
                        the Customer or are not in accordance with any existing mandates given by the Customer. If the
                        Customer requests the Cooperative to cancel any transaction or instruction after a Request has
                        been received by the Cooperative from the Customer, the Cooperative may in its absolute
                        discretion cancel such transaction or instruction but shall have no obligation to do so.
                        6.2 The Cooperative shall be entitled to accept and to act upon any Request, even if the Request
                        is otherwise for any reason incomplete or ambiguous if, in its absolute discretion, the
                        Cooperative believes that it can correct the incomplete or ambiguous information in the Request
                        without reference to the Customer being necessary.
                        6.3 The Cooperative shall not be obliged to accept or to act upon any Request if to do so would
                        require access to, action by, or information from the Agent, or any Subsidiary located in any
                        jurisdiction where it is not a Savings Day at the relevant time when such access, action or
                        information is required or would cause a breach of any existing mandate facility limit or
                        agreement between the Cooperative, the Agent and/or Subsidiary (as applicable) and the Customer.
                        In the event that the Cooperative does accept or act upon any such Request, the Customer shall
                        remain liable thereof.
                        6.4 In the event of any conflict between any terms of any Request from the Customer and the
                        terms of these Terms and Conditions, the terms of these Terms and Conditions shall prevail.
                        These Terms and Conditions and all authorizations and other procedures agreed under these Terms
                        and Conditions supplement any general terms and any mandates, which apply to the Customer’s
                        Savings Accounts with the Cooperative.
                        7. Limits of Internet Savings Transactions
                        7.1 The Customer may transfer or effect a payment for any amount subject to the provisions of
                        paragraph 5.10 of these Terms and Conditions, as long as the transaction does not cause the
                        balance in the Savings/Deposit Account to be less than three thousand Nigerian Naira unless the
                        Customer has either an approved overdraft facility for the affected Savings/Deposit Account or a
                        term Deposit Account pledged with the Cooperative to cover excesses that may arise in the
                        affected Savings/Deposit Account from time to time in which case the two accounts are linked in
                        the System for that purpose.
                        7.2 If the Customer has an approved overdraft facility or term Deposit Account linked to the
                        payment Deposit Account, the transfers and/or electronic bill payments using the Service should
                        not exceed the approved overdraft facility or the pledge term Deposit Account.
                        7.3 if the customer is involved in an empowerment program, loan scheme, Touching Lives Skill
                        Acquisition/ Empowerment program or any other fund scheme as may occur from time to time,
                        funds/grants/Loan from such programs/events though deposited in the Savings account of the
                        customer will not be accessed/withdrawn/transferred whatsoever by the customer except such
                        order/access permit for access is issued to the Cooperative by the empowering/issuing body or
                        any other as may be from time to time but all other deposit made by the customer except the
                        empowerment grant deposit from such corporate/governmental body or any other will be accessed by
                        the customer.
                        7.4 Empowerment funds, grant or loan are facilities for empowerment deposited into the
                        customer’s Savings account pending when the customer meets the eligibility criteria for
                        empowerment as stated on the terms and policy guiding such empowerment and such
                        Corporate/governmental body or whosoever reaches the satisfaction of a customer’s eligibility
                        for empowerment. The Cooperative will put restrictions as may be ordered from
                        Corporate/governmental body or whosoever to the customer’s access to such grant/fund/Loan in the
                        customer’s savings account until such access has been granted by the Corporate/governmental body
                        or whosoever.
                        7.5 the Cooperative also reserves the right to or not to give/add interest on the empowerment
                        funds/grant/Loan deposited by such Corporate/governmental body or whosoever or any empowerment
                        group or person as may come up from time to time in the savings account of the customer as such
                        funds is separately different from the personal savings deposit of the customer and such action
                        may or may not affect the personal savings of the customer.
                        7.6 when the cooperative receives an order or access permit from the corporate/governmental body
                        or group or person to give access to the customer, the cooperative will convert such funds to a
                        personal fund in the customer’s savings account and the cooperative will give access to the
                        customer on such funds.

                        8. Records of Transactions and Customer Rights to this Information
                        8.1 All activities performed by the Customer once allowed access into the System will be logged
                        until the Customer ends a session. The Cooperative shall maintain copies of all Requests
                        received from the Customer in electronic form. In addition, any hard copies of documentation
                        prepared by the Cooperative in the process of effecting a transaction as per the Customer’s
                        Requests will be maintained. As between the Customer and the Cooperative, the Cooperative’s copy
                        records shall be conclusive evidence of the fact of receipt or non-receipt of a Request and of
                        the contents of such Request.
                        8.2 The Customer will be entitled to a monthly statement covering all the Service transactions
                        (hereinafter “the Monthly Statement”). The Customer will also get a reference number upon
                        successful completion of each transfer or electronic bill payment, except for recurring or
                        standing Requests for payments/transfers. A copy of any documentation including the Monthly
                        Statements provided to the Customer by the Cooperative which indicates that a transaction was
                        effected through the Service shall be conclusive evidence of such a transaction and shall
                        constitute prima facie proof that such a payment was made with the Customer’s authority.
                        8.3 The Customer shall be deemed to have accepted and shall not subsequently challenge or object
                        to any of the transactions contained in the Monthly Statement if the Customer fails to object to
                        the Monthly Statement in writing within 30 days from the date the Monthly Statement was sent or
                        deemed to have been sent to the Customer by the Cooperative.
                        9. Charges
                        9.1 The Customer shall pay to the Cooperative an initial set up fee and a monthly subscription
                        fee for the Service in addition to transaction charges applicable to various transaction types
                        as advised by the Cooperative from time to time. The Cooperative may in its sole discretion
                        revise these charges and fees after giving the Customer fourteen (14) calendar days’ notice of
                        such revision.
                        9.2 The Customer shall pay any tax chargeable upon sums payable by the Customer to the
                        Cooperative and also any other charges or duties levied on the Customer or the Cooperative by
                        any governmental or statutory body relating to the provision of the Service.
                        9.3 The Cooperative is hereby irrevocably authorized from time to time to debit any amounts
                        payable by the Customer under the provisions of subparagraphs 9.1 and/or 9.2 to any account in
                        any currency maintained by the Cooperative, the Agent and/or the Cooperative subsidiaries (as
                        applicable) in the name of the Customer. In addition to the fees payable under this agreement,
                        the charges and fees applicable to the Customer’s Savings Account will apply.
                        10. Exclusion of Liability
                        10.1 Circumstance not Within the Cooperative’s Control
                        The Cooperative shall not be responsible or liable for any loss suffered by the Customer should
                        the Service be interfered with or be unavailable by reason of (a) any industrial action, (b) the
                        failure of any the Customer’s Facilities, or (c) any other circumstances whatsoever not
                        reasonably with the Cooperative’s control including, without limitation, force majeure or error,
                        interruption, delay or non-availability of the System, terrorist or any enemy action, equipment
                        failure, loss of power, adverse weather or atmospheric conditions, and failure of any public or
                        private telecommunications systems.
                        10.2 Electronic Bill Payments and Transfer of Funds
                        (a) The Cooperative will not be liable for any losses or damage suffered by the Customer as a
                        result of delay, failure and/or refusal by the Cooperative to act on a Request in time or at all
                        in any one or more of the following circumstances (as the case may be):-
                        i. If the Customer does not have enough funds in the Deposit Account;
                        ii. If the payment or transfer would result in the Customer’s approved overdraft facility limit
                        being exceeded;
                        iii. If the Customer does not authorize a bill payment in good enough time for the payment to be
                        made and properly credited by the payee (the Customer’s counter-party) by the time it is due;
                        iv. If the System or the Customer’s Facilities were not working properly;
                        v. If circumstances beyond the Cooperative’s control including those specified in sub paragraph
                        10.1 above prevent the Cooperative from making a payment or transfer;
                        vi. If the money in the Customer’s account is subject to legal process court order or other
                        encumbrance restricting the payment or transfer;
                        vii. If the Customer does not give proper or complete instructions for the payment or transfer
                        or the Customer does not follow the procedures in this or other applicable agreement with the
                        Cooperative for requesting a payment or a transfer;
                        viii. If the Cooperative has reason to believe that the Customer or someone else is using the
                        Service for fraudulent or illegal purposes;
                        ix. If a payment or a transfer request would consist of money deposited in a form or by a method
                        that has not yet made the money available for withdrawal;
                        x. If the payment or transfer request is in contradiction or conflict with other existing
                        account agreements with the Customer;
                        (b) If the Cooperative makes a timely payment or transfer but the payee nevertheless fails to
                        credit the Customer’s payment promptly after receipt, the Cooperative shall not be liable for
                        any loss or damage suffered by the Customer as a result of such failure on the part of the
                        payee.
                        10.3 Indemnity
                        (a) The Customer shall indemnify and keep the Cooperative indemnified on a full and unqualified
                        indemnity basis against all and any costs (including all legal costs), claims, actions,
                        proceedings, losses, damage, demands, liabilities, and expenses suffered or incurred by the
                        Cooperative in connection with or arising from (a), (b) and/or (c) of subparagraph 10.1 where
                        the particular circumstance is within the Customer’s control and against all and any costs
                        (including all legal costs), claims, actions, proceedings, losses, damage, demands, liabilities,
                        and expenses suffered or incurred by the Cooperative as a consequence of any breach of the
                        Customer of any term or condition hereof.
                        (b) The Customer shall indemnify and keep indemnified the Cooperative against any and all
                        losses, damages, actions, judgments, liabilities, expenses, costs, settlements or claims
                        sustained by the Cooperative in connection with the Service, whether directly or indirectly,
                        unless such losses, damages, actions judgments, liabilities, expenses costs or claims, arose as
                        a direct consequence of the gross negligence or willful misconduct of the Cooperative or any of
                        its employees.
                        (c) Without prejudice to subparagraph 10.3 (b), above, the Customer shall indemnify and keep
                        indemnified the Cooperative against the following:-
                        i. All demands, claims, actions, losses and damages of whatever nature which may be brought
                        against the Cooperative or which it may suffer or incur arising from the Cooperative’s reliance
                        on any incorrect, illegible, incomplete or inaccurate information or data contained in any
                        Request received by the Cooperative.
                        ii. Any loss or damage that may arise from the Customer’s use, misuse, abuse or possession of
                        any third party software, including without limitation, any operating system, browser software
                        or any other software packages or programs.
                        iii. Any unauthorized access to the Customer’s accounts or any breach of security or any
                        destruction or accessing of the Customer’s data or any destruction or theft of or damage to any
                        of the Customer’s equipment.
                        iv. Any loss or damage occasioned by the failure of the Customer to adhere to any terms and
                        conditions applicable to the Service and/or by supplying of incorrect information or loss or
                        damage occasioned by the failure or unavailability of third party facilities or systems or the
                        inability of a third party to process a transaction.
                        10.4 If for any reason other than a reason mentioned in subparagraph 10.1 the Service is
                        interfered with or unavailable, the Cooperative’s sole liability in respect thereof shall be to
                        re-establish the Service as soon as reasonably practicable or, at the Cooperative’s option, to
                        provide to the Customer alternative saving facilities which need not be electronic facilities.
                        10.5 Save as provided in subparagraph 10.4, the Cooperative shall not be liable to the Customer
                        for any interference with or unavailability of the Service, howsoever caused.
                        10.6 Under no circumstances shall the Cooperative be liable to the Customer for any loss of
                        profit, loss of revenue, loss of anticipated savings or for any indirect or consequential loss
                        of whatever kind, howsoever caused, arising out of or in connection with the Service.
                        10.7 Except in respect of death or personal injury caused by the negligence of the Cooperative,
                        the Cooperative shall be under no liability for any claim whatsoever in respect of any terms or
                        conditions contained herein or the performance thereof of any transaction(s) effected by the
                        Cooperative in response to any Request unless the Cooperative has received notice in writing of
                        any such claim from the Customer:
                        a) In the case of any claim relating to a transaction, within thirty (30) days from the date of
                        the alleged transaction on which such claim is based; and
                        b) In all other cases within ninety (90) days of the date of the alleged action or inaction by
                        the Cooperative on which such claim is based.

                        10.8 To the extent permitted by law, the Cooperative:
                        a) Disclaims all warranties with respect to the System and Service either expresses or implied,
                        including but not limited to any implied warranties relating to quality, fitness for any
                        particular purpose or ability to achieve a certain result.
                        b) Makes no warranty that the System is error free or that its use will be uninterrupted and the
                        Customer acknowledges and agrees that the existence of such errors shall not constitute a breach
                        of these Terms and Conditions.
                        11. Amendments
                        The Cooperative may amend or alter these Terms and Conditions from time to time and any such
                        amendments and/or alterations, notice of which has been given to the Customer, shall be binding
                        upon the Customer as fully as if the same were contained herein.
                        12. Termination
                        12.1 Notwithstanding anything contained in these Terms and Conditions, the Subscription may be
                        terminated at any time by either party giving the other thirty (30) calendar days’ notice,
                        PROVIDED that in the event that:-
                        a) the Customer shall have a Receiver or Liquidator appointed or shall pass a resolution for
                        winding up (otherwise than for the purpose of amalgamation or reconstruction) or a court shall
                        make an order to that effect or if the Customer shall enter into any composition or arrangement
                        with creditors or shall become insolvent; or
                        b) any law or regulation is introduced or amended in Akwa Ibom State of Nigeria which would
                        likely result in the Cooperative being prohibited or restricted from complying with the terms of
                        these Terms and Conditions; or
                        c) the Customer’s Savings Account(s) does not have sufficient available balances for the
                        Cooperative to debit the applicable charges as provided in subparagraph 9.1
                        Then the Cooperative shall be entitled to terminate the Subscription forthwith without notice to
                        the Customer.
                        12.2 If the Customer terminates the Subscription, the Cooperative may continue to make
                        electronic bill payments, transfer of funds and other transactions that the Customer would have
                        previously authorized until such time as the Cooperative will have had a reasonable opportunity
                        to act on the Customer’s notice of termination.
                        12.3 The termination of this Subscription shall not, in itself, terminate or affect the
                        relationship of Saver and Customer between the Cooperative and the Customer.
                        12.4 Paragraphs 10, 13.7 and 14 shall survive termination of the Subscription.
                        13. General Provisions
                        13.1 The Customer shall not assign any benefit or any rights arising hereunder without the prior
                        written consent on confirmation from the Cooperative.
                        13.2 No waiver by the Cooperative of any breach by the Customer of any of the Terms and
                        Conditions hereof shall be effective unless it is an express waiver in writing of such breach.
                        No waiver of any such breach shall waive any subsequent breach by the Customer.
                        13.3 The Customer acknowledges:
                        a) That he/she/it has not relied any representation, warranty, promises, statement or opinion or
                        other inducement made or given by or on behalf of or purportedly by or on behalf of the
                        Cooperative in deciding to; and that
                        b) No person has or has authority on behalf of the Cooperative whether before, on or after the
                        subscription to make or give any such representation, warranty, promise, statement or opinion or
                        other inducement to the Customer or to enter into any collateral or side agreement of any kind
                        with the Customer in connection with the Service.
                        13.4 These Terms and Conditions hereof supersede all prior agreements, arrangements and
                        understandings between the Cooperative and the Customer constitutes the entire agreement between
                        the parties relating to the subject matter hereof. For the avoidance of doubt, nothing herein
                        shall vary, discharge or in any other way affect or prejudice any security granted by the
                        Customer or any third party in favour of the Cooperative in relation to any obligations of the
                        Customer which may arise if any Request from the Customer hereunder is acted upon by the
                        Cooperative.
                        13.5 If any provision of these Terms and Conditions is or becomes illegal, invalid or
                        unenforceable in any jurisdiction, such illegality, invalidity or unenforceability shall not
                        affect the legality, validity or enforceability of the remaining provisions of these Terms and
                        Conditions.
                        13.6 Any notice required to be given in writing under these Terms and Conditions shall be
                        sufficiently served if sent by registered post, stamped and properly addressed;
                        a) To the Manager of the Agent or of the Cooperative at the address of the Agent or the
                        Cooperative indicated in the application form as prescribed in subparagraph 2.2 , if to be
                        served on the Cooperative; or
                        b) To the Customer at the address given for the Customer in the application form as prescribed
                        in subparagraph 2.2, if to be served on the Customer and shall be deemed to have been served
                        five Saving days after posting.
                        13.7 Nothing in these Terms and Conditions shall create any agency, fiduciary, joint venture or
                        partnership relationship between customer and the Cooperative
                        14. Confidentiality & Disclosure
                        14.1 The Customer undertakes to maintain strict confidentiality of his/hers/its User
                        ID/Corporate ID and Password and any other information and materials of any nature supplied to
                        it by the Cooperative in relation to the Service. The Customer agrees to notify his/hers/its
                        agents, employees and/or sub-contractors of the provisions of this paragraph and to impose this
                        confidentiality requirement on his/hers/its agents, employees and/or sub-contractors entering
                        into separate agreements, if necessary. The Customer shall be fully liable to the Cooperative
                        for any breach of the provisions of this paragraph by himself/herself/itself, his/her/its
                        employees, agents and/or sub-contractors.
                        14.2 The Customer hereby agrees that, if necessary for the provision of the Service, the
                        Cooperative may disclose information about the Customer to any member of the Cooperative Group
                        or the Customer Group.
                        14.3 The Customer also hereby agrees that the Cooperative may disclose information about the
                        Customer to third parties’ in any of the following circumstances:-
                        (a) Where such disclosure is necessary in order for the Cooperative to act on a Request;
                        (b) In order to comply with any law regulation or court order. If the Cooperative has to obey an
                        order for information from an authorized government body, the Cooperative may, to the extent
                        required by law, notify the Customer before giving out the information;
                        (c) Disclosure to the Cooperative’s agents, sub-contractors, auditors, attorneys and other
                        professional service providers to the extent required in the normal course of their duties;
                        (d) Disclosure to a licensed credit reference agency the services of whom the Cooperative may
                        have subscribed to;
                        (e) If it involves a claim by or against the Cooperative in respect of an item deposited or
                        drawn against the Customer’s account; and
                        (f) If the Customer authorizes the disclosure
                        15. Intellectual property
                        15.1 The Customer acknowledges that the intellectual property rights in the System (and any
                        amendments or enhancements thereto from time to time) and all associated documents that the
                        Cooperative provides to the Customer through the System or otherwise are vested either in the
                        Cooperative or in the other persons from whom the Cooperative has a right to use and to sub
                        license the System and/or the said documentation. The Customer hereby agrees that he/she/it
                        shall not infringe any such intellectual property rights.
                        15.2 The Customer hereby further agrees that he/she/it shall not duplicate, reproduce or in any
                        way tamper with the System and associated documentation without the prior written consent of the
                        Cooperative.
                        16. Governing Law
                        16.1 These terms and conditions shall be governed by and shall be construed according to the
                        laws of Akwa Ibom State.
                        16.2 The Cooperative and Customer hereby submit to the non-exclusive jurisdiction of the Courts
                        of Akwa Ibom State and Nigeria at large and the Cooperative shall be at liberty to enforce a
                        judgment anywhere in any jurisdiction where the Customer carries on business or has any assets.
                        17. Acceptance
                        These terms and conditions (“the Terms”) govern the Cooperative’s respective rights and
                        obligations when you use Internet saving and come into effect when you apply/subscribe for/
                        register for Touching Lives Skills MPCS Limited Internet Savings Service or once you access
                        Touching Lives Skills MPCS Limited Internet Savings Service, whichever occurs first. By making
                        use of Touching Lives Skills MPCS Limited Internet Savings Service, you admit that you have
                        read, and fully understood and agreed to abide and be bound by these Terms and Conditions, and
                        that you have consented to us sharing certain of your personal information within the
                        Cooperative in the ordinary course of our business of providing the Services to you.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-alt-success" data-dismiss="modal">
                        <i class="fa fa-check"></i> Perfect
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
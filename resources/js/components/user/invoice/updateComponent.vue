<template>
    <div class="l-wrap--inner">
        <!-- modal：請求書項目追加 -->
        <div class="l-modal" :class="{'open': isModalInvoiceItemAdd}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalInvoiceItemAdd">
                <div class="l-modal--area__input">
                    <div class="l-modal--area__input__box">
                        <label>品番・品名</label>
                        <input type="text" name="" v-model="itemName">
                    </div>
                    <div class="l-modal--area__input__box">
                        <label>数量</label>
                        <input @input="validateQuantity" v-model="itemNumber"> <!-- 数字のみのバリデーション -->
                    </div>
                    <div class="l-modal--area__input__box">
                        <label>単位</label>
                        <input type="text" name="" v-model="itemUnit">
                    </div>
                    <div class="l-modal--area__input__box">
                        <label>単価</label>
                        <input @input="validatePrice" v-model="itemPrice">
                    </div>
                    <div class="l-modal--area__input__box">
                        <label>金額</label>
                        <span>{{ itemSum }}</span>
                    </div>
                    <div class="l-modal--area__input__submit l-button--submit">
                        <input class="c-button--yellowRounded" type="submit" name="" value="登録する" :disabled="!form_all" :class="{'notSubmit':!form_all}" @click="addItem">
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal：請求書項目追加 -->


        <!-- modal：削除モーダル -->
        <div class="l-modal" :class="{'open': isModalTrash}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalTrush">
                <div class="l-modal__iosModel">
                    <div class="l-modal__iosModel__inner">
                        <p class="c-sentence textCenter">本当に削除しても<br>よろしいでしょうか？</p>
                        <ul class="l-flex trueFalse">
                            <li><a @click.self="toggleModalTrush">いいえ</a></li>
                            <li><a href="">はい</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <!-- fin modal：削除モーダル -->

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">請求書編集</h1>
                <div class="l-wrap--header__inner__sub">
                    <ul class="l-wrap--header__inner__list pc-only">
                        <li class="icon"><a @click="toggleModalTrush"><img src="/img/icon-dust-navygray.png"></a></li>
                    </ul>
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a @click.prevent="toggleModalTrush">
                                <img src="/img/icon-dust-black.png">
                                <span>削除</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="l-wrap--body l-wrap--body__detail l-wrap--body__table">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__detail__box box-left table-input">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">現場情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>件名</th>
                                <td><input type="" name="" v-model="invoice.name" required=""></td>
                            </tr>
                            <tr>
                                <th>請求書番号</th>
                                <td><input type="" name="" v-model="invoice.invoice_number"></td>
                            </tr>
                            <tr>
                                <th>お客様</th>
                                <td>
                                    <div class="c-select--triangle">
                                        <select class="c-input--white" v-model="invoice.client.id">
                                            <option v-for="client in clients" v-bind:key="client.id" v-bind:value="client.id">{{ client.name }}</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <div class="l-flex">
                                        <div class="u-w49per c-input__supplement__box">
                                            <span class="u-color--grayNavy u-mb5 u-textSize--small">発行日</span>
                                            <vuejs-datepicker
                                                v-model="invoice.publish_date"
                                                :language="ja"
                                                :format="DatePickerFormat"
                                                calendar-class="c-bgColor--white"
                                                required=""
                                            >
                                            </vuejs-datepicker>
                                        </div>
                                        <div class="u-w49per c-input__supplement__box vue-right">
                                            <span class="u-color--grayNavy u-mb5 u-textSize--small">支払期限</span>
                                            <vuejs-datepicker
                                                v-model="invoice.limit_date"
                                                :language="ja"
                                                :format="DatePickerFormat"
                                                calendar-class="c-bgColor--white"
                                                required=""
                                            >
                                            </vuejs-datepicker>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="l-wrap--body__detail__box box-right table-input">
                    <div class="l-wrap--body__detail__header">
                        <p class="headline">見積元情報</p>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table">
                            <tr>
                                <th>担当者</th>
                                <td>
                                    <div class="c-select--triangle">
                                        <select class="c-input--white" v-model="invoice.member.id">
                                            <option v-for="member in members" v-bind:key="member.id" v-bind:value="member.id">{{ member.name }}</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>自社名</th>
                                <td>
                                    <span class="u-mb5 u-display--block"><input type="" name="" v-model="invoice.bill_company_name"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="l-wrap--body__detail__body">
                        <table class="l-wrap--body__detail__table" v-if="isInvoiceActive">
                            <tr>
                                <th class="u-w120_pc">郵便番号</th>
                                <td>
                                    <input type="" name="" class="c-input--post__one" v-model="postal1">
                                    <input type="" name="" class="c-input--post__two" v-model="postal2">
                                </td>
                            </tr>
                            <tr>
                                <th>住所</th>
                                <td><input type="" name="" v-model="invoice.bill_address"></td>
                            </tr>
                            <tr>
                                <th>TEL</th>
                                <td><input type="" name="" v-model="invoice.bill_tel"></td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td><input type="" name="" v-model="invoice.bill_email"></td>
                            </tr>
                        </table>
                        <a @click.prevent="toggleInvoiceActive" class="open-detail u-mt10">
                            <span v-if="!isInvoiceActive">詳細（住所、連絡先など）を変更する</span>
                            <span v-else>詳細を閉じる</span>
                        </a>
                    </div>
                </div>
                <div class="l-wrap--body__detail__box l-wrap--body__detail__invoice">
                    <!-- SP start -->
                    <div class="l-wrap--body__detail__invoice__box sp-only">
                        <div class="l-wrap--body__table__area">
                            <div class="l-wrap--body__table__tbody">
                                <div class="l-wrap--body__table__tr" v-for="(invoiceItem, index) in invoice.invoice_items" v-bind:key="invoiceItem.id">
                                    <div class="l-wrap--body__table__tr__inner" v-if="!invoiceItem.deleted_at">
                                        <div class="l-wrap--body__table__td u-w30_sp">
                                            <div class="u-w24_sp">
                                                <img src="/img/icon-minus.png" @click="deleteItem(index)">
                                            </div>
                                        </div>
                                        <div class="l-wrap--body__table__tr__inner u-wflex1_sp">
                                            <div class="l-wrap--body__table__td">
                                                <div class="l-wrap--body__table__td u-mb10">{{ invoiceItem.name }}</div>
                                                <div class="l-wrap--body__table__td c-text--sub_sp u-mb0">{{ invoiceItem.price }}円 × {{ invoiceItem.quantity }}個 ＝ {{ invoiceItem.total }}円(税抜)</div>
                                            </div>
                                        </div>
                                        <div class="l-wrap--body__table__td u-w40_sp">
                                            <div class="l-order__area">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="l-wrap--body__table__tr">
                                    <div class="l-wrap--body__table__tr__inner">
                                        <div class="l-wrap--body__table__td u-w100per_sp">
                                            <a class="c-button--addGreen" @click.self="toggleModalInvoiceItemAdd">品目を追加する</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fin SP -->
                    <div class="l-wrap--body__detail__invoice__box">

                        <!-- PC start -->

                        <table class="field-invoice pc-only">
                            <thead>
                                <tr>
                                    <th class="u-w40 u-border--none" style="background: #fff"></th>
                                    <th class="u-w360">品番・品名</th>
                                    <th class="u-w120">数量</th>
                                    <th class="u-w100">単位</th>
                                    <th class="u-w140">単価</th>
                                    <th class="u-wflex1">金額</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(invoiceItem, index) in invoice.invoice_items" :key="index">
                                    <th class="u-w40 u-border--none" v-if="!invoiceItem.deleted_at">
                                        <span>
                                            <img src="/img/icon-minus.png" @click="deleteItem(index)">
                                        </span>
                                    </th>
                                    <td class="u-w320" v-if="!invoiceItem.deleted_at">
                                        <input type="" name="" v-model="invoiceItem.name">
                                    </td>
                                    <td class="u-w120" v-if="!invoiceItem.deleted_at">
                                        <input type="" name="" v-model="invoiceItem.quantity">
                                    </td>
                                    <td class="u-w100" v-if="!invoiceItem.deleted_at">
                                        <input type="" name="" v-model="invoiceItem.unit">
                                    </td>
                                    <td class="u-w140" v-if="!invoiceItem.deleted_at">
                                        <input type="" name="" v-model="invoiceItem.price">
                                    </td>
                                    <td class="u-wflex1" v-if="!invoiceItem.deleted_at">
                                        <span class="total">{{ invoiceItem.quantity * invoiceItem.price }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="u-border--none" style="vertical-align: middle;">
                                        <span class="c-button--attention" @click="toggleModalInvoiceItemAdd">＋行を追加する</span>
                                    </td>
                                    <td colspan="3" class="u-text--center" style="vertical-align: middle;">小計</td>
                                    <td><span class="total">{{ preTaxTotal }}円</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="u-border--none"></td>
                                    <td colspan="3" class="u-text--center" style="vertical-align: middle;">消費税（10%）</td>
                                    <td><span class="total">{{ tax }}円</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="u-border--none"></td>
                                    <td colspan="3" class="u-text--center" style="vertical-align: middle;">合計</td>
                                    <td><span class="total">{{ total }}円</span></td>
                                </tr>
                            </tbody>
                        </table>
                         <!-- fin PC -->
                        <div class="field-remark">
                            <p>備考 <span>（最大1000文字、20行以内）</span></p>
                            <div class="field-remark__inner">
                                <textarea v-model="invoice.remark"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="l-trackingFooter">
            <div class="l-trackingFooter__inner">
                <div class="l-trackingFooter__box l-trackingFooter__simutale">
                    <table>
                        <tr>
                            <td class="u-pr10 u-pb5">小計</td>
                            <td class="u-pb5">{{ preTaxTotal }}円</td>
                        </tr>
                        <tr>
                            <td class="u-pr10">消費税</td>
                            <td>{{ tax }}円</td>
                        </tr>
                    </table>
                </div>
                <div class="l-trackingFooter__box l-trackingFooter__total">
                    <table>
                        <tr>
                            <th class="u-pr10">合計</th>
                            <th>{{ total }}円</th>
                        </tr>
                    </table>
                </div>
                <div class="l-trackingFooter__box">
                    <div class="l-button--submit">
                        <input type="submit" name="" value="請求書保存" class="c-button--yellowRounded"
                            :disabled="!proccess_all" :class="{'notSubmit':!proccess_all}" @click="updateInvoice">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import vuejsDatepicker from 'vuejs-datepicker'
    import {ja} from 'vuejs-datepicker/dist/locale' // 日本語化

    export default {
        props: ['id'],
        components: {
            'vuejs-datepicker':vuejsDatepicker,
        },
        data() {
            return {
                ja: vdp_translation_ja.js, // カレンダー日本語化
                DatePickerFormat: 'yyyy年MM月dd日', // カレンダーの表示形式
                isInvoiceActive: false, // 詳細情報
                isModalInvoiceItemAdd: false, // 項目追加モーダル
                isModalTrash: false, // 削除モーダル
                itemName: '', // 品番
                itemUnit: '', // 単位
                itemNumber: 0, // 数量
                itemPrice: 0, // 合計
                invoice: {invoice_items: []},
                postal1: '',
                postal2: '',
            }
        },
        created: function() {
            this.loadMembers();
            this.loadClients();
            this.loadInvoiceDetail();
        },
        computed: {
            form_all: function() {
                let required_fields = [
                    this.itemName,
                    this.itemNumber,
                    this.itemUnit,
                    this.itemPrice,
                ]
                return required_fields.indexOf('') === -1
            },
            proccess_all: function() {
                let required_fields = [
                    this.invoice.work_id,
                    this.invoice.invoice_number,
                    this.formatDate(this.invoice.publish_date),
                    this.formatDate(this.invoice.limit_date),
                    this.invoice.remark,
                    this.invoice.memo,
                    this.invoice.status,
                    this.invoice.client_id,
                    this.invoice.member_id,
                ]
                return (required_fields.indexOf('') === -1) && this.invoice.invoice_items && (this.invoice.invoice_items.length > 0)
            },
            // 合計を自動計算
            itemSum: function() {
                return this.itemNumber * this.itemPrice
            },
            preTaxTotal: function() {
                let total = 0;
                this.invoice.invoice_items.forEach(item=> {
                    if (!item.deleted_at) total += item.price * item.quantity;
                });

                return total;
            },
            tax: function() {
                return this.preTaxTotal * 0.1;
            },
            total: function() {
                return this.preTaxTotal + this.tax;
            }
        },
        methods: {
            // 詳細情報
            toggleInvoiceActive: function() {
                this.isInvoiceActive = !this.isInvoiceActive
            },
            // 項目追加モーダル
            toggleModalInvoiceItemAdd: function() {
                this.isModalInvoiceItemAdd = !this.isModalInvoiceItemAdd
            },
            // 削除モーダル
            toggleModalTrush: function() {
                this.isModalTrash = !this.isModalTrash
            },

            // バリデーション：半角数字のみ＋先頭の数字を0以外にする
            validateQuantity: function() {
                if (this.itemQuantity) this.itemQuantity = parseInt(this.itemQuantity.replace(/\D/g, ''), 10)
            },
            validatePrice: function() {
                if (this.itemPrice) this.itemPrice = parseInt(this.itemPrice.replace(/\D/g, ''), 10)
            },

            // 見積書詳細のローディング
            loadInvoiceDetail: function() {
                this.invoice = {invoice_items: [], member: [], client: []};
                axios.get(`/api/user/invoices/${this.id}`)
                .then(
                    (response) => {
                        this.invoice = response.data.data;
                        if (this.invoice.bill_postal && this.invoice.bill_postal.length > 3) {
                            this.postal1 = this.invoice.bill_postal.substring(0, 3);
                            this.postal2 = this.invoice.bill_postal.substring(4);
                        }

                        console.log(this.invoice);
                    }
                );
            },

            // 担当者リストのローディング
            loadMembers: function() {
                this.members = [];
                axios.get('/api/user/members/')
                .then(
                    (response) => {
                        this.members = response.data.data;
                    }
                );
            },

            // お客様リストのローディング
            loadClients: function() {
                this.clients = [];
                axios.get('/api/clients/')
                .then(
                    (response) => {
                        this.clients = response.data.data;
                    }
                );
            },

            // 品目追加
            addItem: function() {
                this.invoice.invoice_items.push({
                    name: this.itemName, price: this.itemPrice, quantity: this.itemNumber, unit: this.itemUnit,
                });
                this.isModalInvoiceItemAdd = false;
                this.itemName = '';
                this.itemPrice = 0;
                this.itemNumber = 0;
                this.itemUnit = '';
            },

            // 品目削除
            deleteItem: function(index) {
                if (this.invoice.invoice_items.length > 1) {
                    this.invoice.invoice_items[index].deleted_at = this.formatDate(new Date());
                }
            },

            // 見積書変更
            updateInvoice: function() {
                axios.put(`/api/user/invoices/${this.id}`, {
                    name: this.invoice.name,
                    invoice_number: this.invoice.invoice_number,
                    publish_date: this.formatDate(this.invoice.publish_date),
                    limit_date: this.formatDate(this.invoice.limit_date),
                    total: this.invoice.total,
                    remark: this.invoice.remark,
                    memo: this.invoice.memo,
                    client_id: this.invoice.client.id,
                    member_id: this.invoice.member.id,
                }).then(response => {
                    console.log(response);
                    this.invoice.invoice_items.forEach((item, i) => {
                        if (item.id) {
                            if (item.deleted_at) {
                                // Delete record
                                axios.delete(`/api/user/invoice-items/${item.id}`)
                                .then(response => {
                                    console.log(response);
                                }).catch(error => {
                                    console.log("Delete: " + error);
                                });
                            } else {
                                // Update record
                                axios.put(`/api/user/invoice-items/${item.id}`, {
                                    invoice_id: this.invoice.id,
                                    name: item.name,
                                    price: item.price,
                                    quantity: item.quantity,
                                    unit: item.unit,
                                    total: item.price * item.quantity,
                                    sort_order: i,
                                }).then(response => {
                                    console.log(response);
                                }).catch(error => {
                                    console.log("Edit: " + error);
                                });
                            }
                        } else {
                            if (!item.deleted_at) {
                                // Add record
                                axios.post('/api/user/invoice-items', {
                                    invoice_id: this.id,
                                    name: item.name,
                                    price: item.price,
                                    quantity: item.quantity,
                                    unit: item.unit,
                                    total: item.price * item.quantity,
                                    sort_order: i,
                                }).then(response => {
                                    console.log(response);
                                }).catch(error => {
                                    console.log("Insert: " + error);
                                });
                            }
                        }
                    });

                    window.history.back();
                }).catch(error => {
                    console.log("Edit: " + error);
                });
            },

            formatDate: function(date) {
                if (!date) return '';

                if (typeof(date) == 'String') return date.substring(0, 10);

                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }
        },
        watch: {
            invoice: function(v) {
                this.invoice.total = this.total;
            },

            total: function(v) {
                this.invoice.total = v;
            },

            postal1: function (val) {
                this.invoice.bill_postal = val + this.postal2
            },

            postal2: function (val) {
                this.invoice.bill_postal = this.postal1 + val
            }
        },
    }
</script>

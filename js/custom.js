var IDMShow=React.createClass({
    render: function(){
	var info=this.props.info;
	return React.createElement(
	    'div',{
		id: 'IDMInner'},
	    ReactBootstrap.Grid,
		    null,
		    React.createElement(
			ReactBootstrap.Row,
			null,
			React.createElement(
			    ReactBootstrap.Col,{
				md: 5},
			    React.createElement(
				ReactBootstrap.Image,{
				    src: info.img},
				null)),
			React.createElement(
			    ReactBootstrap.Col,{
				md: 11},
			    React.createElement(
				'p',
				null,
				'名称: '+info.name),
			    React.createElement(
				'p',
				null,
				'价格: '+info.price),
			    React.createElement(
				'p',
				null,
				'卖家: '+info.owner),
			    React.createElement(
				'p',
				null,
				'余量: '+info.quantity),
			    React.createElement(
				'p',
				null,
				'种类: '+info.kind))));
    }});
var IDMBuy=React.createClass({
    render: function(){
	return React.createElement(
	    'form',
	    null,
	    React.createElement(
		ReactBootstrap.Input,{
		    type: 'text',
		    label: '购买数量',
		    placeholder: '请输入购买数量',
		    value: this.props.purvol,
		    onChange: this.props.purvolChangeHandler},
		null));
    }});

var IDMMsg=React.createClass({
    render: function(){
	return React.createElement(
	    'p',
	    null,
	    this.props.msg);
    }});

var ItemDisplayer=React.createClass({
    handleinvoke: function(itemid){
	var self=this;
	superagent
	    .get('iteminfo.php?itemid='+itemid)
	    .set('Accept', 'application/json')
	    .end(function(err,res){
	    	console.log(res);
		var info={
		    owner: res['text'][1]['name'],
		    tel: res['text'][1].tel,
		    name: res['text'][0].name,
		    price: res['text'][0].price,
		    quantity: res['text'][0].quantity,
		    kind: res['text'][0].kind,
		    img: 'img/'+res['text'][0].pic};
		self.setState({
		    show: true,
	            itemid: itemid,
	            action: 0,
	            info: info});
	    });
    },

    getInitialState: function(){
	return {show: false,action: 2,msg: 'Error:empty'};
    },

    close: function(){
	this.setState({show: false});
    },

    handlePurvolChange(){
    },
    
    toBuy: function(){
	this.setState({purvol: '',action: 1});
    },

    toResult: function(){
	this.setState({action: 2});
    },

    backDisplay: function(){

    },
    
    render: function(){
	var curcont=[IDMShow,IDMBuy,IDMMsg];
	var curconp=[{info: this.state.info},
		     {purvol: this.state.purvol},
		     {msg: this.state.msg}];
	var confirmp=[{bsStyle: 'warning',onClick: this.toBuy},
		      {bsStyle: 'dangerous',onClick: this.toResult},
		      {style: 'display:none'}];
	var confirmc=['我要买','确认购买',null];
	var discardp=[{bsStyle: 'success',onClick: this.close},
		      {bsStyle: 'info',onClick: this.backDisplay},
		      {bsStyle: 'success',onClick: this.close}];
	var discardc=['再逛逛','返回信息展示','知道啦'];
	var action=this.state.action;
	
	return React.createElement(
	    ReactBootstrap.Modal,{
		show: this.state.show,
		onHide: this.close},
	    React.createElement(
		ReactBootstrap.Modal.Header,{
		    closeButton: true},
		React.createElement(
		    ReactBootstrap.Modal.Title,
		    null,
		    this.state.itemid)),
	    
	    React.createElement(
		ReactBootstrap.Modal.Body,
		null,
		React.createElement(
		    curcont[action],
		    curconp[action],
		    null)),

	    React.createElement(
		ReactBootstrap.Modal.Footer,
		null,
		React.createElement(
		    ReactBootstrap.Button,
		    confirmp[action],
		    confirmc[action]),
		React.createElement(
		    ReactBootstrap.Button,
		    discardp[action],
		    discardc[action])));
		    }});

	    
function loadItemDisplayer(mountnodeid){
    var d=React.createElement(ItemDisplayer,null,null);
    return ReactDOM.render(d,document.getElementById(mountnodeid)).handleinvoke;
}

clickshow=loadItemDisplayer('t');


